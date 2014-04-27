<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\Compare;
use SwaggerAssert\Exception\PickException;
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

    /**
     * @param PickResponseAndAnnotation $pick
     */
    public function __construct(PickResponseAndAnnotation $pick)
    {
        $this->pick = $pick;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $this->pick->execute();
        } catch (PickException $e) {
            // 別に catch しなくていい
            return ['isSuccess' => false, 'failMessage' => $e->getMessage()];
        }

        $comparatorFactory = PHPUnit_Framework_ComparatorFactory::getDefaultInstance();

        try {
            $comparetor = $comparatorFactory->getComparatorFor($this->pick->expected(), $this->pick->actual());
            $comparetor->assertEquals($this->pick->actual(), $this->pick->expected(), 0, false, false);
        } catch (\PHPUnit_Framework_ComparisonFailure $e) {
            // TODO:自分のところのエラーエクセプションに差し替え
            $messageHead = "Failed asserting that API response and swagger document are equal.\n";
            $differ = new Differ("--- Response\n +++ Swagger\n");
            print_r($messageHead . $differ->diff($e->getExpectedAsString(), $e->getActualAsString()));
        }

        return [
            'isSuccess'   => true,
            'failMessage' => 'dummy'
        ];
    }

    /**
     * @return string
     */
    protected function failMessage()
    {
        $message = 'Failed asserting that API response and swagger document are equal.' . PHP_EOL;
        $message .= 'response' . var_export($this->pick->actual(), true) . PHP_EOL;
        $message .= 'swagger' . var_export($this->pick->expected(), true) . PHP_EOL;

        return $message;
    }

    /**
     * @return bool
     */
    private function isSuccess()
    {
        $expected = $this->pick->expected();
        $actual = $this->pick->actual();
        $isAssoc = (bool)count(array_filter(array_keys($actual), 'is_string'));
        
        if ($isAssoc) {
            return ($expected === $actual);
        }

        foreach ($actual as $act) {
            if ($act !== $expected) {
                return false;
            }
        }

        return true;
    }
}

