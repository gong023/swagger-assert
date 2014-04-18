<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;

/**
 * SWG\Operationのクラス
 *
 * Class Operation
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations
 */
class Operation
{
    /** @var array $operation */
    private $operation;

    /**
     * コンストラクタ
     *
     * @param array $operation
     */
    public function __construct($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return string
     */
    public function method()
    {
        return $this->operation['method'];
    }

    /**
     * @return string
     */
    public function nickname()
    {
        return $this->operation['nickname'];
    }

    /**
     * @return string
     */
    public function notes()
    {
        return $this->operation['notes'];
    }

    /**
     * @return string
     */
    public function summary()
    {
        return $this->operation['summary'];
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->operation['type'];
    }

    /**
     * @return bool
     */
    public function hasItemsRef()
    {
        return isset($this->operation['items']['$ref']);
    }

    /**
     * @return string
     */
    public function itemsRef()
    {
        return $this->operation['items']['$ref'];
    }

    /**
     * @return Parameters
     */
    public function parameters()
    {
        return new Parameters($this->operation['parameters']);
    }

    /**
     * @return ResponseMessages
     */
    public function responseMessages()
    {
        return new ResponseMessages($this->operation['responseMessages']);
    }
}
