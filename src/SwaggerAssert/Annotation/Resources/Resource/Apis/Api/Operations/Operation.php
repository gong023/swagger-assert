<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;

use SwaggerAssert\Annotation\Individual;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;

/**
 * SWG\Operationのクラス
 */
class Operation extends Individual
{
    /**
     * @return string
     */
    public function method()
    {
        return $this->written('method');
    }

    /**
     * @return string
     */
    public function nickname()
    {
        return $this->written('nickname');
    }

    /**
     * @return string
     */
    public function notes()
    {
        return $this->written('notes');
    }

    /**
     * @return string
     */
    public function summary()
    {
        return $this->written('summary');
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->written('type');
    }

    /**
     * @return bool
     */
    public function hasItemsRef()
    {
        return isset($this->resource['items']['$ref']);
    }

    /**
     * @return string
     */
    public function itemsRef()
    {
        return $this->resource['items']['$ref'];
    }

    /**
     * @return Parameters
     */
    public function parameters()
    {
        return new Parameters($this->written('parameters'));
    }

    /**
     * @return ResponseMessages
     */
    public function responseMessages()
    {
        return new ResponseMessages($this->written('responseMessages'));
    }
}
