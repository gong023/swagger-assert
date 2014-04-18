<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;

/**
 * SWG\Apiのクラス
 *
 * Class Api
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis
 */
class Api
{
    /** @var array $api */
    private $api;

    /**
     * コンストラクタ
     *
     * @param array $api
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return Operations
     */
    public function operations()
    {
        return new Operations($this->api['operations']);
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->api['path'];
    }
}
