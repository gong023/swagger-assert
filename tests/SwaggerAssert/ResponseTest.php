<?php

namespace SwaggerAssert;

class ResponseTest extends TestBase
{
    /**
     * @test
     * @dataProvider getKeysProvider
     */
    public function getKeys($rowData, $expected)
    {
        $response = new Response($rowData);

        $this->assertEquals($expected, $response->getKeys());
    }

    /**
     * @return array
     */
    public static function getKeysProvider()
    {
        return [
            [
                ['a' => 'hoge', 'b' => 'fuga', 'c' => 'foo'],
                ['a', 'b', 'c']
            ],
            [
                ['a' => 'hoge', 'b' => 'fuga', 'c' => ['d' => 'foo', 'e' => ['f' => 'bar']]],
                ['a', 'b', 'c' => ['d', 'e' => ['f']]]
            ]
        ];
    }
}
