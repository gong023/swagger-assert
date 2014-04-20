<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\Compare;
use SwaggerAssert\Response;
use SwaggerAssert\Annotation;
use SwaggerAssert\Exception\AnnotationException;
use SwaggerAssert\Exception\CompareException;

/**
 * Class CompareResponseAndAnnotation
 */
class CompareResponseAndAnnotation extends Compare
{
    /**
     * @param Response $response
     * @param Annotation $annotation
     * @param array $analyzedData
     * @param bool $onlyRequired
     */
    public function __construct(Response $response, Annotation $annotation, $analyzedData, $onlyRequired)
    {
        $this->response = $response;
        $this->annotation = $annotation;
        $this->analyzedData = $analyzedData;
        $this->onlyRequired = $onlyRequired;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $keys = $this->fetchKeys();
        } catch (CompareException $e) {
            return ['isSuccess' => false, 'failMessage' => $e->getMessage()];
        }

        return [
            'isSuccess'   => $this->isSuccess($keys['expected'], $keys['actual']),
            'failMessage' => $this->failMessage($keys['expected'], $keys['actual'])
        ];
    }

    /**
     * @param array $expectedKeys
     * @param array $actualKeys
     * @return string
     */
    protected function failMessage($expectedKeys, $actualKeys)
    {
        $message = 'Failed asserting that API response and swagger document are equal.' . PHP_EOL;
        $message .= 'response' . var_export($actualKeys, true) . PHP_EOL;
        $message .= 'swagger' . var_export($expectedKeys, true) . PHP_EOL;

        return $message;
    }

    /**
     * @return array
     * @throws CompareException
     */
    private function fetchKeys()
    {
        try {
            $expected = $this->readableSort($this->annotation->getKeys($this->analyzedData, $this->onlyRequired));
            $actual   = $this->readableSort($this->response->getKeys());

            return ['expected' => $expected, 'actual' => $actual];
        } catch (AnnotationException $e) {
            throw new CompareException($e->getMessage());
        }
    }

    /**
     * @param array $expected
     * @param array $actual
     * @return bool
     */
    private function isSuccess($expected, $actual)
    {
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

