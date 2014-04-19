<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis;

use SwaggerAssert\TestBase;

class ApiTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0];
        $this->subject = new Api($fixture);
    }

    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals('/simple/{sampleId}', $this->subject->path());
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations', $this->subject->operations());
    }
}
