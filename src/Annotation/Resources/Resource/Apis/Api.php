<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis;

use SwaggerAssert\Annotation\Individual;
use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;

/**
 * SWG\Apiのクラス
 */
class Api extends Individual
{
    /**
     * @return Operations
     */
    public function operations()
    {
        return new Operations($this->written('operations'));
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->written('path');
    }
}
