<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property;

/**
 * SWG\Propertyをコレクションするクラス
 *
 * Class Properties
 * @package SwaggerAssert\Annotation\Resources\Resource\Models\Model
 */
class Properties extends Collection
{
    /** @var array $collections */
    protected $collections = [];

    /**
     * コンストラクタ
     *
     * @param array $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $propertyKey => $items) {
            $this->collections[] = new Property($propertyKey, $items);
        }
    }

    /**
     * Propertyクラスをコレクションした配列を返す
     *
     * @return array
     */
    public function getCollection()
    {
        return $this->collections;
    }
}
