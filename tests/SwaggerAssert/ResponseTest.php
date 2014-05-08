<?php

namespace SwaggerAssert;

class ResponseTest extends TestBase
{
    /**
     * @test
     */
    public function getActualByKeys()
    {
        $this->markTestSkipped();

        $response = new Response(['a' => 'hoge', 'b' => 'fuga', 'c' => 'foo']);
        $actual = $response->getActualByKeys();

        $this->assertEquals(['a', 'b', 'c'], $actual->keys());
    }

    /**
     * @test
     */
    public function getActualByKeysNested()
    {
        $this->markTestSkipped();

        $response = new Response(['a' => 'hoge', 'b' => 'fuga', 'c' => ['d' => 'foo', 'e' => ['f' => 'bar']]]);
        $actual = $response->getActualByKeys();

        $this->assertEquals(['a', 'b', 'c'], $actual->keys());
        $this->assertEquals(['d', 'e'], $actual->c->keys());
    }

    /**
     * @test
     */
    public function getActualByKeysCollection()
    {
        $this->markTestSkipped();

        $sample = ['a', 'b', 'c'];
        $response = new Response([$sample, $sample]);
        $actual = $response->getActualByKeys();

        $this->assertEquals($sample, $actual->keys());
    }

    /**
     * @test
     * @dataProvider collectionProvider
     */
    public function isCollectionWhichDoesNotHaveHashTrue($collection)
    {
        $subject = new Response([]);
        $this->assertTrue($subject->isCollectionWhichDoesNotHaveHash($collection));
    }

    /**
     * @return array
     */
    public static function collectionProvider()
    {
        return [
            [
                ['a', 'b', 'c'],
            ],
            [
                [
                    [['A' => 'a'], ['A' => 'b']],
                    [['B' => 'c'], ['B' => 'd']],
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider hashProvider
     */
    public function isCollectionWhichDoesNotHaveHashFalse($hash)
    {
        $subject = new Response([]);
        $this->assertFalse($subject->isCollectionWhichDoesNotHaveHash($hash));
    }

    /**
     * @return array
     */
    public static function hashProvider()
    {
        return [
            [
                [['A' => 'a'], ['A' => 'b']],
            ],
            [
                [
                    'AA' => [['A' => 'a'], ['A' => 'b']],
                    'BB' => [['B' => 'c'], ['B' => 'c']],
                ]
            ],
            [
                [
                    'A' => ['a', 'b', 'c']
                ]
            ]
        ];
    }
}
