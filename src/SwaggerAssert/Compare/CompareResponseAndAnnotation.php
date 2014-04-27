<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\Compare;
use SwaggerAssert\Exception\CompareException;
use SwaggerAssert\Pick\PickResponseAndAnnotation;
use PHPUnit_Framework_ComparatorFactory;
use SebastianBergmann\Diff\Differ;

/**
 * Class CompareResponseAndAnnotation
 */
class CompareResponseAndAnnotation extends Compare
{
    /** @var PickResponseAndAnnotation $pick */
    private $pick;

    /** @var \PHPUnit_Framework_ComparatorFactory */
    private $comparatorFactory;

    /** @var \SebastianBergmann\Diff\Differ  */
    private $differ;

    /**
     * @param PickResponseAndAnnotation $pick
     */
    public function __construct(PickResponseAndAnnotation $pick)
    {
        $this->pick = $pick;
        $this->comparatorFactory = PHPUnit_Framework_ComparatorFactory::getDefaultInstance();
        $this->differ = new Differ("--- Response\n+++ Swagger\n");
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->pick->execute();

        try {
            $comparator = $this->comparatorFactory->getComparatorFor($this->pick->expected(), $this->pick->actual());
            $comparator->assertEquals($this->pick->actual(), $this->pick->expected(), 0, false, false);
        } catch (\PHPUnit_Framework_ComparisonFailure $e) {
            $messageHead = "Failed asserting that API response and swagger document are equal.\n";
            throw new CompareException($messageHead . $this->differ->diff($e->getExpectedAsString(), $e->getActualAsString()));
        }

        return true;
    }
}

