<?php
namespace SwaggerAssert\Annotation;

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
     * @return mixed
     * @throws AnnotationException
     */
    protected function written($documentedVal)
    {
        if (empty($this->resource[$documentedVal])) {
            $class = explode('\\', get_class($this));
            $class = array_pop($class);
            throw new AnnotationException("specified SWG\\$class $documentedVal is not written in your doc.");
        }

        return $this->resource[$documentedVal];
    }
}
