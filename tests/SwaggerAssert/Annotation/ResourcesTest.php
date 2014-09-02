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
        $expected = $resources->expected('GET', '/simple/{sampleId}', true);

        $this->assertEquals(["simpleKey1", "simpleKey2"], $expected->keys());
    }

    /**
     * @test
     */
    public function expectedKeysWithListOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataCollection'));
        $expected = $resources->expected('GET', '/collection', true);

        $this->assertEquals(['collection'], $expected->keys());
        $this->assertEquals(['key1', 'key2'], $expected->collection->keys());
    }

    /**
     * @test
     */
    public function expectedKeysWithListAndHashOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataModelListAndHash'));
        /**
         * built structure may be...
         * Expected Object (
         *       [refInKey] => Expected Object (
         *           [referenced1] => null
         *           [referenced2] => null
         *       )
         *       [key2] => null
         * )
         */
        $expected = $resources->expected('GET', '/complex/{sampleId}', true);

        $this->assertEquals(['key2', 'refInKey'], $expected->keys());
        $this->assertEquals(['referenced1', 'referenced2'], $expected->refInKey->keys());
    }

    /**
     * @test
     */
    public function expectedKeysWithItemRefOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataModelNested'));
        /**
         * built structure may be...
         * Expected Object (
         *       [collection] => Expected Object (
         *          [refInKey] => Expected Object (
         *              [referenced1] => null
         *              [referenced2] => null
         *          )
         *          [refInKey2] => Expected Object (
         *              [referenced2-1] => Expected Object (
         *                  [referenced3-1] => Expected Object (
         *                      [referenced4-1] => null
         *                      [referenced4-2] => null
         *                  )
         *              )
         *          )
         *       )
         *   )
         */
        $expected = $resources->expected('POST', '/nest/{sampleId}', true);

        $this->assertEquals(['refInKey', 'refInKey2'], $expected->collection->keys());
    }

    /**
     * @test
     * @param string $method
     * @param string $url
     * @dataProvider invalidMethodAndUrlProvider
     * @expectedException \SwaggerAssert\Exception\AnnotationException
     * @expectedExceptionMessage SWG\Model not found. you must write SWG\Operation TYPE and SWG\Model ID correctly
     */
    public function expectedKeysNotFound($method, $url)
    {
        $resources = new Resources($this->fixture('analyzedDataSimple'));
        $resources->expected($method, $url, true);
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
