<?php

namespace SwaggerAssert\ResourcesTest\ResourceTest;

use SwaggerAssert\AnnotationTestBase;
use SwaggerAssert\Annotation\Resources\Resource\Models;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property;

/**
 * Class ModelsTest
 *
 * @package SwaggerAssert\ResourcesTest\ResourceTest
 */
class ModelsTest extends AnnotationTestBase
{
    /** @var Models $subject */
    private $subject = null;

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
        $ret = $this->subject->expectedKeys('entranceModel', true);
        $expected = [
            'refInKey'  => ['referenced1', 'referenced2'],
            'refInKey2' => [
                'referenced2-1' => [
                    'referenced3-1' => [
                        'referenced4-1', 'referenced4-2'
                    ]
                ]
            ]
        ];

        $this->assertSame($expected, $ret);
    }

    /**
     * @test
     */
    public function expectedKeysWithNotOnlyRequired()
    {
        $ret = $this->subject->expectedKeys('entranceModel', false);
        $expected = [
            'refInKey'  => ['referenced1', 'referenced2'],
            'refInKey2' => [
                'referenced2-1' => [
                    'referenced3-1' => [
                        'referenced4-1', 'referenced4-2'
                    ]
                ]
            ],
            'refInKey3'
        ];

        $this->assertSame($expected, $ret);
    }

    /**
     * @test
     */
    public function referencedKeysWithNotOnlyRequired()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $property = new Property('refInKey', $fixture['Nests']['models']['entranceModel']['properties']['refInKey']);
        $ret = $this->subject->referencedKeys($property, false);

        $this->assertSame(['refInKey' => ['referenced1', 'referenced2']], $ret);
    }

    /**
     * @test
     */
    public function referencedKeysWithNotOnlyRequiredRecursively()
    {
        $fixture = $this->fixture('analyzedDataModelNested');
        $property = new Property('refInKey2', $fixture['Nests']['models']['entranceModel']['properties']['refInKey2']);
        $ret = $this->subject->referencedKeys($property, false);
        $expected = [
            'refInKey2' => [
                'referenced2-1' => [
                    'referenced3-1' => [
                        'referenced4-1', 'referenced4-2'
                    ]
                ]
            ]
        ];

        $this->assertSame($expected, $ret);
    }
}
