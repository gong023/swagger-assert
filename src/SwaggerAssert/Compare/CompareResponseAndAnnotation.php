<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\Compare;
use SwaggerAssert\Exception\PickException;
use SwaggerAssert\Pick\PickResponseAndAnnotation;

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
            return ['isSuccess' => false, 'failMessage' => $e->getMessage()];
        }

        return [
            'isSuccess'   => $this->isSuccess(),
            'failMessage' => $this->failMessage()
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

