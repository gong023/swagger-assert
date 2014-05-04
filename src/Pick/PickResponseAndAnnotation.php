<?php

namespace SwaggerAssert\Pick;

use SwaggerAssert\Pick;
use SwaggerAssert\Response;
use SwaggerAssert\Annotation;

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
        $this->expected = $this->annotation->getKeys();
        $this->actual   = $this->response->parse();
    }
}