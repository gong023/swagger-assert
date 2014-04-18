<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation;

use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters\Parameter;

/**
 * SWG\Parameterをコレクションするクラス
 *
 * Class Parameters
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation
 */
class Parameters extends Collection
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
            $this->collections[] = new Parameter($resource);
        }
    }
}
