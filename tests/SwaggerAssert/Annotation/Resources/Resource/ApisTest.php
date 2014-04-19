<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\TestBase;

class ApisTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'];
        $this->subject = new Apis($fixture);
    }

    /**
     * @test
     */
    public function exists()
    {
        $this->assertTrue($this->subject->exists('path', '/simple/{sampleId}'));
    }

    /**
     * @test
     */
    public function pick()
    {
        $picked = $this->subject->pick('path', '/simple/{sampleId}');
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis\Api', $picked);
    }

    /**
     * @test
     */
    public function pickAll()
    {
        $this->assertInternalType('array', $this->subject->pickAll('path', '/simple/{sampleId}'));
    }
}