<?php

namespace SwaggerAssert;

class ResponseTest extends TestBase
{
    /**
     * @test
     */
    public function getActualByKeys()
    {
        $response = new Response(['a' => 'hoge', 'b' => 'fuga', 'c' => 'foo']);
        $actual = $response->getActualByKeys();

        $this->assertEquals(['a', 'b', 'c'], $actual->keys());
    }

    /**
     * @test
     */
    public function getActualByKeysNested()
    {
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
        $sample = [['A' => 'a', 'B' => 'a'], ['A' => 'b', 'B' => 'b'], ['A' => 'c', 'B' => 'c']];
        $response = new Response($sample);
        $actual = $response->getActualByKeys();

        $this->assertEquals(['collection'], $actual->keys());
        $this->assertEquals(['A', 'B'], $actual->collection->keys());
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
