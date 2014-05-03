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

    public function expectedKeysWithListOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataAssoc'));
        $ret = $resources->expectedKeys('GET', '/assoc', true);
        $expected =  ['a', 'b', 'c'];

        $this->assertEquals($expected, $ret);
    }

    /**
     * @test
     */
    public function expectedKeysWithListAndHashOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataModelListAndHash'));
        $ret = $resources->expectedKeys('GET', '/complex/{sampleId}', true);
        $expected = [
            'refInKey' => ['referenced1', 'referenced2'],
            'key2'
        ];

        $this->assertEquals($expected, $ret);
    }

    /**
     * @test
     */
    public function expectedKeysWithItemRefOnlyRequiredTrue()
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

    /**
     * @test
     * @param string $method
     * @param string $url
     * @dataProvider invalidMethodAndUrlProvider
     * @expectedException \SwaggerAssert\Exception\AnnotationException
     * @expectedExceptionMessage SWG\Model not found. you must write SWG\Operation TYPE and SWG\Model ID correctly, or use $ref key
     */
    public function expectedKeysNotFound($method, $url)
    {
        $resources = new Resources($this->fixture('analyzedDataSimple'));
        $resources->expectedKeys($method, $url, true);
    }

    /**
     * @return array
     */
    public static function invalidMethodAndUrlProvider()
    {
        return [
            ['GET', 'invalid url'],
            ['invalid method', '/simple/{sampleId}'],
        ];
    }
}
