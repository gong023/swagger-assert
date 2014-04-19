<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models;

use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

/**
 * SWG\Modelのクラス
 *
 * Class Model
 * @package SwaggerAssert\Annotation\Resources\Resource\Models
 */
class Model
{
    /** @var array $model */
    private $model;

    /**
     * @param array $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->model['description'];
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->model['id'];
    }

    /**
     * @return string
     */
    public function required()
    {
        return $this->model['required'];
    }

    /**
     * @param bool $onlyRequired
     * @return Properties
     */
    public function properties($onlyRequired)
    {
        if (! $onlyRequired) {
            return new Properties($this->model['properties']);
        }

        $filtered = [];
        foreach ($this->model['properties'] as $propertyKey => $propertyVal) {
            if (in_array($propertyKey, $this->required())) {
                $filtered[$propertyKey] = $propertyVal;
            }
        }

        return new Properties($filtered);
    }
}
