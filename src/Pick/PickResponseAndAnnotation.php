<?php

namespace SwaggerAssert\Pick;

use SwaggerAssert\PickInterface;
use SwaggerAssert\Response;
use SwaggerAssert\Annotation;

class PickResponseAndAnnotation implements PickInterface
{
    /* @var array $expected */
    protected $expected;

    /* @var array $actual */
    protected $actual;

    /**
     * @param Response $response
     * @param Annotation $annotation
     */
    public function __construct(Response $response, Annotation $annotation)
    {
        $this->response = $response;
        $this->annotation = $annotation;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->expected = $this->annotation->getExpected();
        $this->actual   = $this->response->getActualByKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function expected()
    {
        return $this->expected;
    }

    /**
     * {@inheritdoc}
     */
    public function actual()
    {
        return $this->actual;
    }
}