<?php

namespace SwaggerAssertTest\Annotation\Resources\Resource\Apis\Api\Operations\Operation;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages;
use SwaggerAssertTest\TestBase;

class ResponseMessagesTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'][0]['responseMessages'];
        $this->subject = new ResponseMessages($fixture);
    }

    /**
     * @test
     */
    public function exists()
    {
        $this->assertTrue($this->subject->exists('message', 'internal error1'));
    }

    /**
     * @test
     */
    public function pick()
    {
        $picked = $this->subject->pick('message', 'internal error1');
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages\ResponseMessage', $picked);
    }
}