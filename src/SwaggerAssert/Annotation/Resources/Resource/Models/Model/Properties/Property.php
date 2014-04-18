<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

/**
 * SWG\Propertyのクラス
 *
 * Class Property
 * @package SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties
 */
class Property
{
    /** @var string $propertyKey */
    private $propertyKey;

    /** @var array $propertyKey */
    private $items;

    /**
     * コンストラクタ
     *
     * @param string $propertyKey
     * @param array $items
     */
    public function __construct($propertyKey, $items)
    {
        $this->propertyKey = $propertyKey;
        $this->items = $items;
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
        return $this->items['description'];
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->items['type'];
    }

    /**
     * このプロパティが他のモデルを参照しているかどうかをboolで返す
     *
     * @return bool
     */
    public function hasRef()
    {
        return isset($this->items['$ref']);
    }

    /**
     * このプロパティが参照しているModelのidを返す
     *
     * @return string
     */
    public function refModelId()
    {
        return $this->items['$ref'];
    }
}
