<?php

namespace SwaggerAssertTest\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters\Parameter;
use SwaggerAssertTest\TestBase;

class ParameterTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'][0]['parameters'][0];
        $this->subject = new Parameter($fixture);
    }

    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals('something id', $this->subject->description());
        $this->assertEquals('sampleId', $this->subject->name());
        $this->assertEquals('string', $this->subject->type());
        $this->assertEquals('path', $this->subject->paramType());
    }
} 