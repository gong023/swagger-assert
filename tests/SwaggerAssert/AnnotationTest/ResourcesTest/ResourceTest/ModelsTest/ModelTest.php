<?php

namespace SwaggerAssert\ResourcesTest\ResourceTest\ModelsTest;

use SwaggerAssert\Annotation\Resources\Resource\Models\Model;
use SwaggerAssert\AnnotationTestBase;

/**
 * Class PropertyTest
 *
 * @package SwaggerAssert\ResourcesTest\ResourceTest\ModelsTest
 */
class ModelTest extends AnnotationTestBase
{
    /**
     * @test
     */
    public function propertiesWithOnlyRequiredFalse()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $subject = new Model($fixture['Nests']['models']['entranceModel']);

        $this->assertCount(3, $subject->properties(false)->getCollection());
    }

    /**
     * @test
     */
    public function propertiesWithOnlyRequiredTrue()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $subject = new Model($fixture['Nests']['models']['entranceModel']);

        $this->assertCount(2, $subject->properties(true)->getCollection());
    }
}
