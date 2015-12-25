<?php
namespace GraphCommons;

use GraphCommons\GraphCommons;
use GraphCommons\GraphCommonsApiException;
use GraphCommons\Util\Util;
use GraphCommons\Graph\Graph;
use GraphCommons\Graph\Entity\Image as GraphImage;
use GraphCommons\Graph\Entity\License as GraphLicense;
use GraphCommons\Graph\Entity\Layout as GraphLayout;
use GraphCommons\Graph\Entity\{
    User as GraphUser, Users as GraphUsers
};
use GraphCommons\Graph\Entity\{
    Node as GraphNode, Nodes as GraphNodes,
    NodeType as GraphNodeType, NodeTypes as GraphNodeTypes
};
use GraphCommons\Graph\Entity\{
    Edge as GraphEdge, Edges as GraphEdges,
    EdgeType as GraphEdgeType, EdgeTypes as GraphEdgeTypes
};

final class GraphCommonsApi
{
    final public function __construct(GraphCommons $graphCommons)
    {
        $this->graphCommons = $graphCommons;
    }

    final public function status()
    {
        $response = $this->graphCommons->client->get('/status');
        if ($response->ok()) {
            return $response->getBodyData();
        }
        return null;
    }

    final public function getGraph(string $id): Graph
    {
        $response = $this->graphCommons->client->get('/graphs/'. $id);
        if (!$response->ok()) {
            $exception = Util::getResponseException($response);
            throw new GraphCommonsApiException(sprintf('API error: code(%d) message(%s)',
                $exception['code'], $exception['message']
            ),  $exception['code']);
        }

        $graph = new Graph();
        $graph->setReadonly(false);

        if (!empty($responseData = $response->getBodyData())) {
            $g =& $responseData->graph;
            $graph->setId($g->id);
            $graph->setName($g->name);
            $graph->setSubtitle($g->subtitle);
            $graph->setDescription($g->description);
            $graph->setCreatedAt($g->created_at);
            $graph->setUpdatedAt($g->updated_at);
            $graph->setStatus($g->status);

            $image = (new GraphImage($graph))
                ->setPath($g->image->path)
                ->setRefName($g->image->ref_name)
                ->setRefUrl($g->image->ref_url)
            ; $graph->setImage($image);

            $license = (new GraphLicense($graph))
                ->setType($g->license->type)
                ->setCcBy($g->license->cc_by)
                ->setCcSa($g->license->cc_sa)
                ->setCcNd($g->license->cc_nd)
                ->setCcNc($g->license->cc_nc)
            ; $graph->setLicense($license);

            $layout = (new GraphLayout($graph))
                ->setSpringLength($g->layout->springLength)
                ->setGravity($g->layout->gravity)
                ->setSpringCoeff($g->layout->springCoeff)
                ->setDragCoeff($g->layout->dragCoeff)
                ->setTheta($g->layout->theta)
                ->setAlgorithm($g->layout->algorithm)
                ->setTransform($g->layout->transform)
            ; $graph->setLayout($layout);

            $graph->setUsers(new GraphUsers());
            if (!empty($g->users)) foreach ($g->users as $_) {
                $user = (new GraphUser($graph))
                    ->setId($_->id)
                    ->setUsername($_->username)
                    ->setFullname($_->fullname)
                    ->setFirstName($_->first_name)
                    ->setLastName($_->last_name)
                    ->setIsOwner($_->is_owner)
                    ->setIsAdmin($_->is_admin)
                    ->setImgPath($_->img_path)
                ; $graph->users->set($user);
            }

            $graph->setNodes(new GraphNodes());
            if (!empty($g->nodes)) foreach ($g->nodes as $_) {
                $node = (new GraphNode($graph))
                    ->setId($_->id)
                    ->setType($_->type_id)
                    ->setTypeId($_->type_id)
                    ->setName($_->name)
                    ->setDescription($_->description)
                    ->setImage($_->image)
                    ->setReference($_->reference)
                    ->setProperties($_->properties)
                    ->setPosXY($_->pos_x, $_->pos_y)
                ; $graph->nodes->set($node);
            }

            $graph->setNodeTypes(new GraphNodeTypes());
            if (!empty($g->nodeTypes)) foreach ($g->nodeTypes as $_) {
                $nodeType = (new GraphNodeType($graph))
                    ->setId($_->id)
                    ->setName($_->name)
                    ->setNameAlias($_->name_alias)
                    ->setDescription($_->description)
                    ->setImage($_->image)
                    ->setImageAsIcon((bool) $_->image_as_icon)
                    ->setColor($_->color)
                    ->setProperties($_->properties)
                    ->setHideName((bool) $_->hide_name)
                    ->setSize($_->size)
                    ->setSizeLimit($_->size_limit)
                ; $graph->nodeTypes->set($nodeType);
            }

            $graph->setEdges(new GraphEdges());
            if (!empty($g->edges)) foreach ($g->edges as $_) {
                $edge = (new GraphEdge($graph))
                    ->setId($_->id)
                    ->setName($_->name)
                    ->setUserId($_->type_id)
                    ->setTypeId($_->user_id)
                    ->setFrom($_->from)
                    ->setTo($_->to)
                    ->setWeight($_->weight)
                    ->setDirected($_->directed)
                    ->setProperties($_->properties)
                ; $graph->edges->set($edge);
            }

            $graph->setEdgeTypes(new GraphEdgeTypes());
            if (!empty($g->edgeTypes)) foreach ($g->edgeTypes as $_) {
                $nodeType = (new GraphEdgeType($graph))
                    ->setId($_->id)
                    ->setName($_->name)
                    ->setNameAlias($_->name_alias)
                    ->setDescription($_->description)
                    ->setWeighted($_->weighted)
                    ->setDirected($_->directed)
                    ->setDurational($_->durational)
                    ->setColor($_->color)
                    ->setProperties($_->properties)
                ; $graph->edgeTypes->set($nodeType);
            }
        }

        // @todo
        // convert each json object to graph entity object

        return $graph;
    }
}
