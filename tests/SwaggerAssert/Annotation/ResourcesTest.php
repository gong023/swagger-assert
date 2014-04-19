<?php

namespace SwaggerAssert\Annotation;

use SwaggerAssert\TestBase;

class ResourcesTest extends TestBase
{
    /**
     * @test
     */
    public function expectedKeysWithOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataSimple'));
        $ret = $resources->expectedKeys('GET', '/simple/{sampleId}', true);

        $this->assertEquals(["simpleKey1", "simpleKey2"], $ret);
    }

    /**
     * @test
     */
    public function expectedKeysWithItemRef()
    {
        $resources = new Resources($this->fixture('analyzedDataModelNested'));
        $ret = $resources->expectedKeys('POST', '/nest/{sampleId}', true);
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

        $this->assertEquals($expected, $ret);
    }
}
