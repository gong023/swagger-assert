<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties;

use SwaggerAssert\TestBase;

class PropertyTest extends TestBase
{
    /** @var Property $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['models']['sampleModel']['properties']['simpleKey1'];
        $this->subject = new Property('simpleKey1', $fixture);
    }
    
    /**
     * @test
     */
    public function normalCases()
    {
        $this->assertEquals('simpleKey1', $this->subject->key());
        $this->assertEquals('key of 1', $this->subject->description());
        $this->assertEquals('string', $this->subject->type());
    }
}
