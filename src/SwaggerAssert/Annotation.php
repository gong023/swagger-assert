<?php

namespace SwaggerAssert;

use SwaggerAssert\Annotation\Resources;

class Annotation
{
    /** @var string $httpMethod */
    private $httpMethod;

    /** @var string $url */
    private $url;

    /**
     * @param string $httpMethod
     * @param string $url
     */
    public function __construct($httpMethod, $url)
    {
        $this->httpMethod = $httpMethod;
        $this->url = $url;
    }

    /**
     * @param array $analyzedData
     * @param bool $onlyRequired
     * @return array
     */
    public function getKeys($analyzedData, $onlyRequired)
    {
        $resources = new Resources($analyzedData);

        return $resources->expectedKeys($this->httpMethod, $this->url, $onlyRequired);
    }
}

