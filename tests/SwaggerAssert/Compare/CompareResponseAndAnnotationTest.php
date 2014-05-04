<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\TestBase;

class CompareResponseAndAnnotationTest extends TestBase
{
    /**
     * @test
     * @param $expectedMockVal
     * @param $actualMockVal
     * @dataProvider normalCasesProvider
     */
    public function normalCases($expectedMockVal, $actualMockVal)
    {
        $picker = $this->createPickerMock($expectedMockVal, $actualMockVal);
        $subject = new CompareResponseAndAnnotation($picker);

        $this->assertTrue($subject->execute());
    }

    /**
     * @return array
     */
    public static function normalCasesProvider()
    {
        $sample = ['a', 'b', 'c'];
        $sample2 = ['d', 'e' => ['f', 'g']];

        return [
            // simple
            [$sample, $sample],
            // expected is different order
            [['c', 'b', 'a'], $sample],
            // actual is different order
            [$sample, ['c', 'b', 'a']],
            // assoc
            [$sample, [$sample, $sample, $sample]],
            // mix of assoc and hash
            [
                ['a', 'b', 'c' => ['d', 'e']],
                ['a', 'b', 'c' => [['d', 'e'], ['d', 'e']]]
            ],
            // mixes of assoc and hash
            [
                ['a', 'b' => ['c', 'd'], 'e' => ['f', 'g']],
                ['a', 'b' => [['c', 'd'], ['c', 'd']], 'e' => [['f', 'g'], ['f', 'g']]]
            ],
            // nests mix
            [
                ['a', 'b', 'c' => $sample2],
                ['a', 'b', 'c' => [$sample2, $sample2]],
            ]
        ];
    }

    /**
     * @test
     * @param $expectedMockVal
     * @param $actualMockVal
     * @dataProvider abnormalCasesProvider
     * @expectedException \SwaggerAssert\Exception\CompareException
     */
    public function abnormalCases($expectedMockVal, $actualMockVal)
    {
        $picker = $this->createPickerMock($expectedMockVal, $actualMockVal);
        $subject = new CompareResponseAndAnnotation($picker);

        $subject->execute();
    }

    /**
     * @return array
     */
    public static function abnormalCasesProvider()
    {
        $sample = ['a', 'b', 'c'];

        return [
            // not enough actual keys
            // TODO:fix
//            [$sample, ['a', 'b']],
            // too many actual keys
            [$sample, ['a', 'b', 'c', 'd']]
        ];
    }
    /**
     * @param array $expectedMockVal
     * @param array $actualMockVal
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createPickerMock($expectedMockVal, $actualMockVal)
    {
        $pickerStub = $this->getMockBuilder('SwaggerAssert\PickInterface')->setMethods(['execute', 'expected', 'actual'])->getMock();
        $pickerStub->expects($this->any())->method('execute')->will($this->returnValue(null));
        $pickerStub->expects($this->any())->method('expected')->will($this->returnValue($expectedMockVal));
        $pickerStub->expects($this->any())->method('actual')->will($this->returnValue($actualMockVal));

        return $pickerStub;
    }
} 