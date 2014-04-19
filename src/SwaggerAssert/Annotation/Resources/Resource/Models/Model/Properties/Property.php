<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

use SwaggerAssert\Annotation\Individual;

/**
 * SWG\Propertyのクラス
 */
class Property extends Individual
{
    /** @var string $propertyKey */
    private $propertyKey;

    /**
     * コンストラクタ
     *
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
     * このプロパティが他のモデルを参照しているかどうかをboolで返す
     *
     * @return bool
     */
    public function hasRef()
    {
        return isset($this->resource['$ref']);
    }

    /**
     * このプロパティが参照しているModelのidを返す
     *
     * @return string
     */
    public function refModelId()
    {
        return $this->resource['$ref'];
    }
}
