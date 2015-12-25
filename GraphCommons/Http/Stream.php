<?php
namespace GraphCommons\Http;

abstract class Stream
{
    const HTTP_VERSION = '1.0';
    const TYPE_REQUEST = 1,
          TYPE_RESPONSE = 2;
    private $type;
    private $httpVersion;
    private $headers = array();
    private $body = '';
    private $bodyData = array();
    private $failCode = 0;
    private $failText = '';

    final public function __toString(): string
    {
        return $this->toString();
    }

    final public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }
    final public function setHttpVersion(string $httpVersion): self
    {
        $this->httpVersion = $httpVersion;
        return $this;
    }
    final public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }
    final public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }
    final public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
    final public function setBodyData(array $bodyData): self
    {
        $this->bodyData = $bodyData;
        return $this;
    }
    final public function setFailCode(int $failCode): self
    {
        $this->failCode = $failCode;
        return $this;
    }
    final public function setFailText(string $failText): self
    {
        $this->failText = $failText;
        return $this;
    }

    final public function getType(): int
    {
        return $this->type;
    }
    final public function getHttpVersion(): string
    {
        return $this->httpVersion;
    }
    final public function getHeader(string $key)
    {
        return $this->headers[$key] ?? null;
    }
    final public function getHeaders(): array
    {
        return $this->headers;
    }
    final public function getBody(): string
    {
        return $this->body;
    }
    final public function getBodyData(string $key = null)
    {
        if ($key === null) {
            return $this->bodyData;
        }
        return $this->bodyData[$key] ?? null;
    }
    final public function getFailCode(): int
    {
        return $this->failCode;
    }
    final public function getFailText(): string
    {
        return $this->failText;
    }

    abstract public function toString(): string;
}
