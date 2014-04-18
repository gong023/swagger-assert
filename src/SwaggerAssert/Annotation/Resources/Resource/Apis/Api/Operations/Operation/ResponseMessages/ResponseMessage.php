<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;

/**
 * SWG\ResponseMessageのクラス
 *
 * Class ResponseMessage
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages
 */
class ResponseMessage
{
    /** @var array $responseMessage */
    private $responseMessage;

    /**
     * @param array $responseMessage
     */
    public function __construct($responseMessage)
    {
        $this->responseMessage = $responseMessage;
    }

    /**
     * @return integer
     */
    public function code()
    {
        return $this->responseMessage['code'];
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->responseMessage['message'];
    }
}
