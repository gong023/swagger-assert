<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

use SwaggerAssert\Annotation\Individual;

/**
 * class of SWG\Property
 */
class Property extends Individual
{
    /** @var string $propertyKey */
    private $propertyKey;

    /**
     * @param string $propertyKey
     * @param array $resource
     */
    public function __construct($propertyKey, $resource)
    {
        $this->propertyKey = $propertyKey;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->propertyKey;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->written('description');
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->written('type');
    }

    /**
     * return bool whether this property referenced another model or not
     *
     * @return bool
     */
    public function hasRef()
    {
        return isset($this->resource['$ref']);
    }

    /**
     * return model id referenced this property
     *
     * @return string
     */
    public function refModelId()
    {
        return $this->resource['$ref'];
    }

    /**
     * return bool whether this property references another collection or not
     *
     * @return bool
     */
    public function hasItemsRef()
    {
        return isset($this->resource['items']) && isset($this->resource['items']['$ref']);
    }

    /**
     * return model id referenced this property as collection
     *
     * @return string
     */
    public function itemsRefModelId()
    {
        return $this->resource['items']['$ref'];
    }
}
