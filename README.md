# Swagger-assert
enable to assert swagger doc keys and API response.

[![Build Status](https://travis-ci.org/gong023/swagger-assert.svg)](https://travis-ci.org/gong023/swagger-assert)
[![Coverage Status](https://coveralls.io/repos/gong023/swagger-assert/badge.png?branch=master)](https://coveralls.io/r/gong023/swagger-assert?branch=master)

## Installation
composer
```javascript
    "require-dev": {
        "gong023/swagger-assert": "dev-master"
    }
```
requires PHP5.4+

## Usage

### Sample API
Sample API is below. Swagger-assert enables you to assert that `/plain` response has swagger keys `id`,`name`.

```php
/**
 * @SWG\Resource(
 *     resourcePath="plain",
 *     @SWG\Api(
 *         path="/plain",
 *         description="plain api structure",
 *         @SWG\Operation(
 *             method="GET",type="SimpleMember",nickname="plain"
 *         )
 *     )
 * )
 *
 * @SWG\Model(
 *     id="SimpleMember",
 *     @SWG\Property(name="id", type="integer", required=true, description="user id"),
 *     @SWG\Property(name="name", type="string", required=true, description="user name")
 * )
 */
$app->get('/plain', function () use ($app) {
    $response = [
        'id'   => 0,
        'name' => 'kohsaka'
    ];

    return $app->json($response);
});
```

### Ready
At first, call `SwaggerAssert::analyze` at the start of the test. Argument is directory path where annotation file exists.

```php
// testing bootstrap.php
\SwaggerAssert\SwaggerAssert::analyze($targetDir);
```

### Assert keys
Second, call `SwaggerAssert::responseHasSwaggerKeys` in test class.
 - First argument: array of API response
 - Second argument: string of http method
 - Third argument: url of API endpoint

When testing the sample API by PHPUnit, code is as follows.

```php
class PlainApiTest extends \PHPUnit_Framework_TestCase
{
    public function testResponseHasSwaggerKeys()
    {
        $response = $this->request('get', '/plain');
        $result = \SwaggerAssert::responseHasSwaggerKeys(array $response, 'get', '/plain', $onlyRequired = true);

        $this->assertTrue($result);
    }
}
```
`\SwaggerAssert::responseHasSwaggerKeys` compares API response keys and keys in swagger doc and return true when they match.
If they differs, output below error message.

```
SwaggerAssert\Exception\CompareException: Failed asserting that API response and swagger document are equal.
--- Response
+++ Swagger
@@ @@
 Array (
-    0 => 'id'
-    1 => 'name'
+    0 => 'name'
 )
```
The fourth argument is optional. If you give false, `responseHasSwaggerKeys` contains required=false keys to assert. Default value is true.

if you need more sample, please take a look at [swagger-assert-sandbox](https://github.com/gong023/swagger-assert-sandbox).

## Motivation
Swagger doc and API response sometimes differ. If they differ, the swagger doc causes confusion in development.
So create library to assert API response and swagger doc.

## Bugs & Contributions
Please report bugs by opening an issue.

Contributions are welcome.
