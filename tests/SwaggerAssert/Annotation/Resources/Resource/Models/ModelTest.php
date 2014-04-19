<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models;

use SwaggerAssert\TestBase;

class ModelTest extends TestBase
{
    /** @var Model $subject */
    private $subject;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $this->subject = new Model($fixture['Nests']['models']['entranceModel']);
    }

    /**
     * @test
     */
    public function id()
    {
        $this->assertEquals('entranceModel', $this->subject->id());
    }

    /**
     * @test
     */
    public function description()
    {
        $this->assertEquals('This is sample api structure', $this->subject->description());
    }

    /**
     * @test
     */
    public function propertiesWithOnlyRequiredFalse()
    {
        $this->assertCount(3, $this->subject->properties(false)->getCollection());
    }

    /**
     * @test
     */
    public function propertiesWithOnlyRequiredTrue()
    {
        $this->assertCount(2, $this->subject->properties(true)->getCollection());
    }
}
