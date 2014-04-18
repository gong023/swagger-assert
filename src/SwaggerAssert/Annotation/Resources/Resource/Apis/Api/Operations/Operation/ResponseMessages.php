<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages\ResponseMessage;

/**
 * SWG\ResponseMessageをコレクションするクラス
 *
 * Class ResponseMessages
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation
 */
class ResponseMessages extends Collection
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
            $this->collections[] = new ResponseMessage($resource);
        }
    }
}
