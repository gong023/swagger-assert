<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation;

/**
 * SWG\Operationをコレクションするクラス
 *
 * Class Operations
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api
 */
class Operations extends Collection
{
    /** @var array $collections */
    protected $collections = [];

    /**
     * コンストラクタ
     *
     * @param $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $resource) {
            $this->collections[] = new Operation($resource);
        }
    }

    /**
     * strtoupperするのでオーバーライト
     * {@inheritdoc}
     */
    public function exists($key, $val)
    {
        foreach ($this->collections as $operation) {
            if (strtoupper(call_user_func_array([$operation, $key], [])) == strtoupper($val)) {
                return true;
            }
        }

        return false;
    }

    /**
     * strtoupperするのでオーバーライト
     * {@inheritdoc}
     */
    public function pick($key, $val)
    {
        foreach ($this->collections as $operation) {
            if (strtoupper(call_user_func_array([$operation, $key], [])) == strtoupper($val)) {
                return $operation;
            }
        }
    }
}
