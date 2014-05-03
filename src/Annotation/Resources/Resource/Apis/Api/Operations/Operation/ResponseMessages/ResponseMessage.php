<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;
use SwaggerAssert\Annotation\Individual;

/**
 * SWG\ResponseMessageのクラス
 */
class ResponseMessage extends Individual
{
    /**
     * @return integer
     */
    public function code()
    {
        return $this->written('code');
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->written('message');
    }
}
