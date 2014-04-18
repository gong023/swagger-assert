<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api;

/**
 * SWG\Apiをコレクションするクラス
 *
 * Class Apis
 * @package SwaggerAssert\Annotation\Resources\Resource
 */
class Apis extends Collection
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
        foreach ($resources as $resource) {
            $this->collections[] = new Api($resource);
        }
    }

    /**
     * １つのエンドポイントに複数のhttpメソッドが割り当てられている場合があるので、
     * Apiクラスを一意に決めることができず配列を返さざるを得ない
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
