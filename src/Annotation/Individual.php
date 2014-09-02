<?php
namespace SwaggerAssert\Annotation;

use SwaggerAssert\Annotation;
use SwaggerAssert\Exception\AnnotationException;

/**
 * Class Individual
 */
class Individual
{
    /** @var array $resource */
    protected $resource;

    /**
     * @param array $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param mixed $documentedVal
     * @param string $specified
     * @return mixed
     * @throws AnnotationException
     */
    protected function written($documentedVal, $specified = 'specified')
    {
        if (empty($this->resource[$documentedVal])) {
            $class = explode('\\', get_class($this));
            $class = array_pop($class);
            $url = Annotation::$url;
            $httpMethod = Annotation::$httpMethod;
            throw new AnnotationException("$specified SWG\\$class $documentedVal is not written in your doc. httpMethod: $httpMethod, url: $url");
        }

        return $this->resource[$documentedVal];
    }
}
