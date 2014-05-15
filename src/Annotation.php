<?php

namespace SwaggerAssert;

use SwaggerAssert\Annotation\Resources;
use SwaggerAssert\Exception\AnnotationException;

/**
 * Class Annotation
 */
class Annotation
{
    /* @var string $httpMethod */
    public static $httpMethod;

    /* @var string $url */
    public static $url;

    /* @var array $analyzedData */
    private $analyzedData;

    /* @var bool $url */
    private $onlyRequired;

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $analyzedData
     * @param bool $onlyRequired
     */
    public function __construct($httpMethod, $url, $analyzedData, $onlyRequired)
    {
        self::$httpMethod = $httpMethod;
        self::$url = $url;
        $this->analyzedData = $analyzedData;
        $this->onlyRequired = $onlyRequired;
    }

    /**
     * @throws Exception\AnnotationException
     * @return \SwaggerAssert\Container\Expected
     */
    public function getExpected()
    {
        if (empty($this->analyzedData)) {
            throw new AnnotationException("Annotation data is empty.You need to call \\SwaggerAssert::analyze at the start of the test.");
        }
        $resources = new Resources($this->analyzedData);

        return $resources->expected(self::$httpMethod, self::$url, $this->onlyRequired);
    }
}

