<?php

namespace SwaggerAssert;

use SwaggerAssert\Annotation\Resources;

/**
 * Class Annotation
 */
class Annotation
{
    /** @var string $httpMethod */
    private $httpMethod;

    /** @var string $url */
    private $url;

    /** @var array $analyzedData */
    private $analyzedData;

    /** @var bool $url */
    private $onlyRequired;

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $analyzedData
     * @param bool $onlyRequired
     */
    public function __construct($httpMethod, $url, $analyzedData, $onlyRequired)
    {
        $this->httpMethod = $httpMethod;
        $this->url = $url;
        $this->analyzedData = $analyzedData;
        $this->onlyRequired = $onlyRequired;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        $resources = new Resources($this->analyzedData);

        return $resources->expectedKeys($this->httpMethod, $this->url, $this->onlyRequired);
    }
}

