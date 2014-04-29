<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\TestBase;

class CompareResponseAndAnnotationTest extends TestBase
{
    /**
     * @test
     * @param array $expectedMockVal
     * @param array $actualMockVal
     * @dataProvider normalCasesProvider
     */
    public function normalCases($expectedMockVal, $actualMockVal)
    {
        $picker = $this->createPickerMock($expectedMockVal, $actualMockVal);
        $subject = new CompareResponseAndAnnotation($picker);

        $this->assertTrue($subject->execute());
    }

    /**
     * @test
     * @group tmp
     * @dataProvider normalCasesProvider
     * @param $expectedMockVal
     * @param $actualMockVal
     */
    public function tmpTest($expectedMockVal, $actualMockVal)
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

        return [
            // simple
            [$sample, $sample],
            // expected is different order
            [['c', 'b', 'a'], $sample],
            // actual is different order
            [$sample, ['c', 'b', 'a']],
            // assoc
            [$sample, [$sample, $sample, $sample]],
            // mix
            [
                ['a', 'b', 'c' => ['d', 'e']],
                ['a', 'b', 'c' => [['d', 'e'], ['d', 'e']]]
            ],
            // mix
//            [
//                ['a', 'b' => ['c', 'd'], 'e' => ['f', 'g']],
//                ['a', 'b' => [['c', 'd'], ['c', 'd']], 'e' => [['f', 'g'], ['f', 'g']]]
//            ]
        ];
    }

    /**
     * @param array $expectedMockVal
     * @param array $actualMockVal
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createPickerMock($expectedMockVal, $actualMockVal)
    {
        $pickerStub = $this->getMockBuilder('Comparator')->setMethods(['execute', 'expected', 'actual'])->getMock();
        $pickerStub->expects($this->any())->method('execute')->will($this->returnValue(null));
        $pickerStub->expects($this->any())->method('expected')->will($this->returnValue($expectedMockVal));
        $pickerStub->expects($this->any())->method('actual')->will($this->returnValue($actualMockVal));

        return $pickerStub;
    }
} 