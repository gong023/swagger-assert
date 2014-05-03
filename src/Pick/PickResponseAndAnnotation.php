<?php

namespace SwaggerAssert\Pick;

use SwaggerAssert\Pick;
use SwaggerAssert\Response;
use SwaggerAssert\Annotation;
use SwaggerAssert\Exception\PickException;
use SwaggerAssert\Exception\AnnotationException;

class PickResponseAndAnnotation extends Pick
{
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
        try {
            $this->expected = $this->readableSort($this->annotation->getKeys());
            $this->actual   = $this->readableSort($this->response->getKeys());
        } catch (AnnotationException $e) {
            throw new PickException($e->getMessage());
        }
    }
}