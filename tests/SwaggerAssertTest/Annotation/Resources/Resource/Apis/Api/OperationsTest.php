<?php

namespace SwaggerAssertTest\Annotation\Resources\Resource\Apis\Api;

use SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations;
use SwaggerAssertTest\TestBase;

class OperationsTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['apis'][0]['operations'];
        $this->subject = new Operations($fixture);
    }

    /**
     * @test
     */
    public function exists()
    {
        $this->assertTrue($this->subject->exists('method', 'get'));
    }

    /**
     * @test
     */
    public function pick()
    {
        $picked = $this->subject->pick('method', 'get');
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation', $picked);
    }
}