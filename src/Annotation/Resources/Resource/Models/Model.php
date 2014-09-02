<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models;

use SwaggerAssert\Annotation\Individual;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

/**
 * class of SWG\Model
 */
class Model extends Individual
{
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
    public function id()
    {
        return $this->written('id');
    }

    /**
     * @return string
     */
    public function required()
    {
        return $this->written('required');
    }

    /**
     * @param bool $onlyRequired
     * @return Properties
     */
    public function properties($onlyRequired)
    {
        if (! $onlyRequired) {
            return new Properties($this->written('properties'));
        }

        $filtered = [];
        foreach ($this->written('properties', $this->id()) as $propertyKey => $propertyVal) {
            if (in_array($propertyKey, $this->required())) {
                $filtered[$propertyKey] = $propertyVal;
            }
        }

        return new Properties($filtered);
    }
}
