<?php

namespace SwaggerAssert;

class ResponseTest extends TestBase
{
    /**
     * @test
     * @param array $rowData
     * @param array $keys
     * @dataProvider parseProvider
     */
    public function parse($rowData, $keys)
    {
        $response = new Response($rowData);
        $parsed = $response->parse();

        $this->assertEquals($keys, $parsed->keys());
    }

    /**
     * @return array
     */
    public static function parseProvider()
    {
        return [
            [
                ['a' => 'hoge', 'b' => 'fuga', 'c' => 'foo'],
                ['a', 'b', 'c']
            ],
            [
                ['a' => 'hoge', 'b' => 'fuga', 'c' => ['d' => 'foo', 'e' => ['f' => 'bar']]],
                ['a', 'b', 'c']
            ]
        ];
    }
}
