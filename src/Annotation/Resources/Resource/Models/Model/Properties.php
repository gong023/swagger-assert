<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property;

/**
 * class of SWG\Property
 */
class Properties extends Collection
{
    /* @var array $collections */
    protected $collections = [];

    /**
     * @param array $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $propertyKey => $items) {
            $this->collections[] = new Property($propertyKey, $items);
        }
    }

    /**
     * return collection of Property
     *
     * @return array
     */
    public function getCollection()
    {
        return $this->collections;
    }
}
