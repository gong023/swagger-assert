<?php

namespace SwaggerAssert;

use SwaggerAssert\Annotation\Resources;

/**
 * 本当はResources以下のそれぞれのクラスについてテストを書くのが良い気がするが、mock化が大変なのでここで全てテストしてしまう
 *
 * Class Resources
 * @package SwaggerAssert
 */
class ResourcesTesting extends AnnotationTestBase
{
    /**
     * @test
     * @return Resource $sampleResource
     */
    public function resources()
    {

        $resources = new Resources($this->fixture('analyzedDataSimple'));
        $sampleResource = $resources->pick('filename', 'Simples');

        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource', $sampleResource);

        return $sampleResource;
    }

    /**
     * @test
     */
    public function resourcesExpectedKeysWithOnlyRequiredTrue()
    {
        $resources = new Resources($this->fixture('analyzedDataSimple'));
        $ret = $resources->expectedKeys('GET', '/simple/{sampleId}', true);

        $this->assertEquals(["simpleKey1", "simpleKey2"], $ret);
    }

    /**
     * @test
     */
    public function resourcesExpectedKeysWithItemRef()
    {
        $resources = new Resources($this->fixture('analyzedDataModelNested'));
        $ret = $resources->expectedKeys('POST', '/nest/{sampleId}', true);
        $expected = [
            'refInKey'  => ['referenced1', 'referenced2'],
            'refInKey2' => [
                'referenced2-1' => [
                    'referenced3-1' => [
                        'referenced4-1', 'referenced4-2'
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $ret);
    }

    /**
     * @test
     * @depends resources
     * @param $sampleResource
     * @return $sampleResource
     */
    public function resourceSimpleMethods($sampleResource)
    {
        $this->assertEquals('Simples', $sampleResource->filename());
        $this->assertEquals('dummy string', $sampleResource->basePath());
        $this->assertEquals('SimpleApi', $sampleResource->resourcePath());
        $this->assertEquals('1.2', $sampleResource->swaggerVersion());

        return $sampleResource;
    }

    /**
     * @test
     * @depends resourceSimpleMethods
     * @param $sampleResource
     * @return $apis
     */
    public function resourceApis($sampleResource)
    {
        $apis = $sampleResource->apis();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis', $apis);

        return $apis;
    }

    /**
     * @test
     * @depends resourceApis
     * @param $apis
     * @return $sampleApi
     */
    public function apis($apis)
    {
        $this->assertTrue($apis->exists('path', '/simple/{sampleId}'));
        $sampleApi = $apis->pick('path', '/simple/{sampleId}');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api', $sampleApi);

        return $sampleApi;
    }

    /**
     * @test
     * @depends apis
     * @param $sampleApi
     * @return $sampleApi
     */
    public function apiPath($sampleApi)
    {
        $this->assertEquals('/simple/{sampleId}', $sampleApi->path());

        return $sampleApi;
    }

    /**
     * @test
     * @depends apiPath
     * @param $sampleApi
     * @return $sampleOperations
     */
    public function apiOperations($sampleApi)
    {
        $sampleOperations = $sampleApi->operations();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations', $sampleOperations);

        return $sampleOperations;
    }

    /**
     * @test
     * @depends apiOperations
     * @param $sampleOperations
     * @return $sampleOperation
     */
    public function operations($sampleOperations)
    {
        $this->assertTrue($sampleOperations->exists('method', 'GET'));
        $sampleOperation = $sampleOperations->pick('method', 'GET');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation', $sampleOperation);

        return $sampleOperation;
    }

    /**
     * @test
     * @depends operations
     * @param $sampleOperation
     * @return $sampleOperation
     */
    public function operationSimpleMethods($sampleOperation)
    {
        $this->assertEquals('GET', $sampleOperation->method());
        $this->assertEquals('simpleTestCase', $sampleOperation->nickname());
        $notes = 'simple api which does not nest model';
        $this->assertEquals($notes, $sampleOperation->notes());
        $this->assertEquals("doesn't nest model", $sampleOperation->summary());
        $this->assertEquals('sampleModel', $sampleOperation->type());

        return $sampleOperation;
    }

    /**
     * @test
     * @depends operationSimpleMethods
     * @param $sampleOperation
     * @return $sampleParameters
     */
    public function operationParameters($sampleOperation)
    {
        $sampleParameters = $sampleOperation->parameters();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters', $sampleParameters);

        return $sampleParameters;
    }

    /**
     * @test
     * @depends operationSimpleMethods
     * @param $sampleOperation
     * @return $sampleParameters
     */
    public function operationResponseMessages($sampleOperation)
    {
        $sampleMessages = $sampleOperation->responseMessages();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages', $sampleMessages);

        return $sampleMessages;
    }

    /**
     * @test
     * @depends operationParameters
     * @param $sampleParameters
     * @return $sampleParameter
     */
    public function parameters($sampleParameters)
    {
        $sampleParameter = $sampleParameters->pick('name', 'sampleId');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters\Parameter', $sampleParameter);

        return $sampleParameter;
    }

    /**
     * @test
     * @depends parameters
     * @param  $sampleParameter
     */
    public function parameterSimpleMethods($sampleParameter)
    {
        $this->assertEquals('something id', $sampleParameter->description());
        $this->assertEquals('sampleId', $sampleParameter->name());
        $this->assertEquals('path', $sampleParameter->paramType());
        $this->assertEquals('string', $sampleParameter->type());
    }

    /**
     * @test
     * @depends operationResponseMessages
     * @param $sampleMessages
     * @return $sampleMessage
     */
    public function responseMessages($sampleMessages)
    {
        $sampleMessage = $sampleMessages->pick('message', 'internal error1');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\ResponseMessages\ResponseMessage', $sampleMessage);

        return $sampleMessage;
    }

    /**
     * @test
     * @depends responseMessages
     * @param $responseMessage
     */
    public function responseMessageSimpleMethods($responseMessage)
    {
        $this->assertEquals(500, $responseMessage->code());
        $this->assertEquals('internal error1', $responseMessage->message());
    }

    /**
     * @test
     * @depends resourceSimpleMethods
     * @param $sampleResource
     * @return $models
     */
    public function resourceModels($sampleResource)
    {
        $models = $sampleResource->models();
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Models', $models);

        return $models;
    }

    /**
     * @test
     * @depends resourceModels
     * @param $models
     * @return $model
     */
    public function models($models)
    {
        $this->assertTrue($models->exists('id', 'sampleModel'));
        $sampleModel = $models->pick('id', 'sampleModel');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Models\Model', $sampleModel);

        return $sampleModel;
    }

    /**
     * @test
     * @depends models
     * @param $model
     * @return $model
     */
    public function modelSimpleMethods($model)
    {
        $this->assertEquals('This is sample api structure', $model->description());
        $this->assertEquals('sampleModel', $model->id());
        $this->assertEquals(['simpleKey1', 'simpleKey2'], $model->required());

        return $model;
    }

    /**
     * @test
     * @depends modelSimpleMethods
     * @param $model
     * @return $properties
     */
    public function modelProperties($model)
    {
        $properties = $model->properties(false);
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties', $properties);

        return $properties;
    }

    /**
     * @test
     * @depends modelProperties
     * @param $properties
     * @return $sampleProperty
     */
    public function properties($properties)
    {
        $sampleProperty = $properties->pick('key', 'simpleKey1');
        $this->assertInstanceOf('\SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property', $sampleProperty);

        return $sampleProperty;
    }

    /**
     * @test
     * @depends properties
     * @param $property
     */
    public function propertySimpleMethods($property)
    {
        $this->assertEquals('simpleKey1', $property->key());
        $this->assertEquals('key of 1', $property->description());
        $this->assertEquals('string', $property->type());
    }
}
