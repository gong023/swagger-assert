<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api;

/**
 * collection of SWG\Api
 *
 * Class Apis
 */
class Apis extends Collection
{
    /* @var array $collections */
    protected $collections = [];

    /**
     * @param array $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $resource) {
            $this->collections[] = new Api($resource);
        }
    }

    /**
     * endpoint may have multiple http methods.
     * so cannot return unique instance
     *
     * @param string $key
     * @param string $val
     * @return array
     */
    public function pickAll($key, $val)
    {
        $matchCollection = [];
        foreach ($this->collections as $collection) {
            if (call_user_func_array([$collection, $key], []) == $val) {
                $matchCollection[] = $collection;
            }
        }

        return $matchCollection;
    }
}
