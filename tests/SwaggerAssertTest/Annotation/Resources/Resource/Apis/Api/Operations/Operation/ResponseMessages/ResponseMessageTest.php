<?php

namespace SwaggerAssertTest\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages\ResponseMessage;
use SwaggerAssertTest\TestBase;

class ResponseMessageTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'][0]['responseMessages'][0];
        $this->subject = new ResponseMessage($fixture);
    }

    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals(500, $this->subject->code());
        $this->assertEquals('internal error1', $this->subject->message());
    }
}
