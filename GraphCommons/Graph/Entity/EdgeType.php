<?php
namespace GraphCommons\Graph\Entity;

use GraphCommons\Graph\GraphEntity;

final class EdgeType extends GraphEntity
{
    private $id;
    private $name;
    private $nameAlias;
    private $description;
    private $weighted;
    private $directed;
    private $durational;
    private $color;
    private $properties;

    final public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    final public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    final public function setNameAlias(string $nameAlias): self
    {
        $this->nameAlias = $nameAlias;
        return $this;
    }
    final public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    final public function setWeighted(int $weighted): self
    {
        $this->weighted = $weighted;
        return $this;
    }
    final public function setDirected(int $directed): self
    {
        $this->directed = $directed;
        return $this;
    }
    final public function setDurational(float $durational): self
    {
        $this->durational = $durational;
        return $this;
    }
    final public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }
    final public function setProperties(\stdClass $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    final public function getId(): string
    {
        return $this->id;
    }
    final public function getName(): string
    {
        return $this->name;
    }
    final public function getNameAlias(): string
    {
        return $this->nameAlias;
    }
    final public function getDescription(): string
    {
        return $this->description;
    }
    final public function getWeighted(): int
    {
        return $this->weighted;
    }
    final public function getDirected(): int
    {
        return $this->directed;
    }
    final public function getDurational(): float
    {
        return $this->durational;
    }
    final public function getColor(): string
    {
        return $this->color;
    }
    final public function getProperties(): \stdClass
    {
        return $this->properties;
    }
}
