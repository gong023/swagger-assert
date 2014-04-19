<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;

use SwaggerAssert\TestBase;

class OperationTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'][0];
        $this->subject = new Operation($fixture);
    }

    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals('GET', $this->subject->method());
        $this->assertEquals('simpleTestCase', $this->subject->nickname());
        $this->assertEquals('simple api which does not nest model', $this->subject->notes());
        $this->assertEquals("doesn't nest model", $this->subject->summary());
        $this->assertEquals('sampleModel', $this->subject->type());
        $sampleParameters = $this->subject->parameters();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters', $sampleParameters);
        $sampleMessages = $this->subject->responseMessages();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages', $sampleMessages);
    }
}
