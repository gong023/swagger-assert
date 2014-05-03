<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\TestBase;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property;

class ModelsTest extends TestBase
{
    /** @var Models $subject */
    private $subject = null;

    /**
     * setUp
     */
    public function setUp()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $this->subject = new Models($fixture['Nests']['models']);
    }

    /**
     * @test
     */
    public function expectedKeysWithOnlyRequiredTrue()
    {
        /**
         * built structure may be...
         * Expected Object (
         *       [refInKey] => Expected Object (
         *           [referenced1] => null
         *           [referenced2] => null
         *       )
         *       [refInKey2] => Expected Object (
         *           [referenced2-1] => Expected Object (
         *               [referenced3-1] => Expected Object (
         *                   [referenced4-1] => null
         *                   [referenced4-2] => null
         *               )
         *           )
         *       )
         *   )
         */
        $built = $this->subject->buildExpectedByModelId('entranceModel', true);

        $this->assertEquals(['refInKey', 'refInKey2'], $built->keys());
        $this->assertEquals(['referenced1', 'referenced2'], $built->refInKey->keys());
        $this->assertEquals(['referenced2-1'], $built->refInKey2->keys());
        $escapeA = 'referenced2-1'; $escapeB = 'referenced3-1';
        $this->assertEquals(['referenced4-1', 'referenced4-2'], $built->refInKey2->$escapeA->$escapeB->keys());
    }

    /**
     * @test
     */
    public function expectedKeysWithNotOnlyRequired()
    {
        $built = $this->subject->buildExpectedByModelId('entranceModel', false);

        $this->assertEquals(['refInKey', 'refInKey2', 'refInKey3'], $built->keys());
    }

    /**
     * @test
     * @expectedException \SwaggerAssert\Exception\AnnotationException
     * @expectedExceptionMessage specified SWG\Model is not written in your doc.
     */
    public function expectedKeysWithInvalidModelId()
    {
        $this->subject->buildExpectedByModelId('not exists', false);
    }
}
