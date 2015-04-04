<?php

namespace SwaggerAssertTest;

class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * fixture
     *
     * @param string $fileName
     * @return array
     */
    protected function fixture($fileName)
    {
        $fileContent = file_get_contents(__DIR__ . "/../fixture/$fileName.json");

        return json_decode($fileContent, true);
    }
}
