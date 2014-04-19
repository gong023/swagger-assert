<?php

namespace SwaggerAssert\Annotation\Resources;

use SwaggerAssert\TestBase;

class ResourceTest extends TestBase
{
    /** @var Resource $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples'];
        $this->subject = new Resource('Simples', $fixture);
    }

    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals('Simples', $this->subject->filename());
        $this->assertEquals('dummy string', $this->subject->basePath());
        $this->assertEquals('SimpleApi', $this->subject->resourcePath());
        $this->assertEquals('1.2', $this->subject->swaggerVersion());
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Apis', $this->subject->apis());
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Models', $this->subject->models());
    }

    /**
     * @test
     * @expectedException \SwaggerAssert\Exception\AnnotationException
     * @expectedExceptionMessage specified SWG\Resource apis is not written in your doc.
     */
    public function apisNotWritten()
    {
        $subject = new Resource('Simples', ['Simples' => []]);
        $subject->apis();
    }
}
