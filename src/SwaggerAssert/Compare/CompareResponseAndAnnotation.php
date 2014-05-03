<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\Compare;
use SwaggerAssert\Exception\CompareException;
use PHPUnit_Framework_ComparatorFactory;
use SebastianBergmann\Diff\Differ;

/**
 * Class CompareResponseAndAnnotation
 */
class CompareResponseAndAnnotation extends Compare
{
    /** @var \SwaggerAssert\Pick\PickResponseAndAnnotation $pick */
    private $pick;

    /** @var \PHPUnit_Framework_ComparatorFactory */
    private $comparatorFactory;

    /** @var \SebastianBergmann\Diff\Differ  */
    private $differ;

    /**
     * @param \SwaggerAssert\Pick\PickResponseAndAnnotation $pick
     */
    public function __construct($pick)
    {
        $this->pick = $pick;
        $this->pick->execute();
        $this->comparatorFactory = PHPUnit_Framework_ComparatorFactory::getDefaultInstance();
        $this->differ = new Differ("--- Response\n+++ Swagger\n");
    }

    /**
     * {@inheritdoc}
     * @return bool
     * @throws CompareException
     */
    public function execute()
    {
        // sort() は参照で行われるので別関数に分けている
        return $this->assertValues($this->pick->expected(), $this->pick->actual());
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     * @return bool
     * @throws CompareException
     */
    private function assertValues($expected, $actual)
    {
        foreach ($actual as $actualVal) {
            if (is_array($actualVal)) {
                $this->emulateAssertEquals(asort($expected), asort($actual));
                continue;
            }

            if (! in_array($actualVal, $expected)) {
                throw new CompareException('nothing!!!');
            }
        }

        return true;
    }

    /**
     * @throws CompareException
     */
    private function emulateAssertEquals($expected, $actual)
    {
        try {
            $comparator = $this->comparatorFactory->getComparatorFor($expected, $actual);
            $comparator->assertEquals($actual, $expected, 0, false, false);
        } catch (\PHPUnit_Framework_ComparisonFailure $e) {
            $messageHead = "Failed asserting that API response and swagger document are equal.\n";
            throw new CompareException($messageHead . $this->differ->diff($e->getExpectedAsString(), $e->getActualAsString()));
        }
    }
}
