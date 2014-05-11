<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\CompareInterface;
use SwaggerAssert\PickInterface;
use SwaggerAssert\Exception\CompareException;
use PHPUnit_Framework_ComparatorFactory;
use SebastianBergmann\Diff\Differ;

/**
 * Class CompareResponseAndAnnotation
 */
class CompareResponseAndAnnotation implements CompareInterface
{
    /* @var \SwaggerAssert\Pick\PickResponseAndAnnotation $pick */
    private $pick;

    /* @var \PHPUnit_Framework_ComparatorFactory */
    private $comparatorFactory;

    /* @var \SebastianBergmann\Diff\Differ  */
    private $differ;

    /**
     * @param \SwaggerAssert\PickInterface $pick
     */
    public function __construct(PickInterface $pick)
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
     * @param \SwaggerAssert\Container\Expected|null $expected
     * @param \SwaggerAssert\Container\Actual|null $actual
     * @return bool
     */
    public function _execute($expected = null, $actual = null)
    {
        if (is_null($expected)) {
            $expected = $this->pick->expected();
        }
        if (is_null($actual)) {
            $actual = $this->pick->actual();
        }

        $this->emulateAssertEquals($expected->keys(), $actual->keys());

        $references = $expected->references();
        if (isset($references)) {
            foreach ($references as $referenceKey => $referenceVal) {
                $this->_execute($referenceVal, $actual->$referenceKey);
            }
        }

        return true;
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
