<?php

namespace SwaggerAssertTest\Annotation\Resources\Resource\Apis\Api\Operations\Operation;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;
use SwaggerAssertTest\TestBase;

class ParametersTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'][0]['parameters'];
        $this->subject = new Parameters($fixture);
    }

    /**
     * @test
     */
    public function exists()
    {
        $this->assertTrue($this->subject->exists('name', 'sampleId'));
    }

    /**
     * @test
     */
    public function pick()
    {
        $picked = $this->subject->pick('name', 'sampleId');
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters\Parameter', $picked);
    }
}