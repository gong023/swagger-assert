<?php

namespace SwaggerAssert\Pick;

use SwaggerAssert\Annotation;
use SwaggerAssert\Response;
use SwaggerAssert\TestBase;

class PickResponseAndAssertionTest extends TestBase
{
    /**
     * @test
     * @dataProvider readableSortProvider
     */
    public function readableSort($sample, $expected)
    {
        $dummyResponse = new Response([]);
        $dummyAnnotation = new Annotation('', '', [], false);
        $pick = new PickResponseAndAnnotation($dummyResponse, $dummyAnnotation);

        $this->assertEquals($expected, $pick->readableSort($sample));
    }

    /**
     * @return array
     */
    public static function readableSortProvider()
    {
        return [
            [
                // simple case
                ['c', 'b', 'a'],
                ['a', 'b', 'c']
            ],
            [
                // list with hash
                ['c' => ['C', 'B'], 'b', 'a'],
                ['a', 'b', 'c' => ['B', 'C']]
            ],
            [
                // hash
                ['c' => ['C', 'B'], 'b' => ['C', 'B'], 'a' => ['C', 'B']],
                ['a' => ['B', 'C'], 'b' => ['B', 'C'], 'c' => ['B', 'C']]
            ],
            [
                // nests many times
                ['c' => ['C' => ['CC', 'BB'], 'B'], 'b', 'a'],
                ['a', 'b', 'c' => ['B', 'C' => ['BB', 'CC']]]
            ]
        ];
    }
}
