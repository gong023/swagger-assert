<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Models\Model;

use SwaggerAssert\TestBase;

class PropertiesTest extends TestBase
{
    /** @var Properties $subject */
    private $subject = null;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataSimple')['Simples']['models']['sampleModel']['properties'];
        $this->subject = new Properties($fixture);
    }

    /**
     * @test
     */
    public function getCollection()
    {
        $collection = $this->subject->getCollection();
        $this->assertInternalType('array', $collection);
        $this->assertInstanceOf('SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property', $collection[0]);
    }
}
