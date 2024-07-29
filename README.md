![guzzle](https://raw.githubusercontent.com/guzzle/guzzle/master/.github/logo.png)

# Guzzle, PHP HTTP client

Guzzle is a PHP HTTP client that makes it easy to send HTTP requests and trivial to integrate with web services.

Simple interface for building query strings, POST requests, streaming large uploads, streaming large downloads, using HTTP cookies, uploading JSON data, etc...

But It's hard to read response form end points.

This package will help you to get data easier than usual.

## Instaliation

```shell
composer require rp76/guzzle
```

## Usage

```php
$client = new \Rp76\Guzzle\Client(); // make new instance

$request = new \GuzzleHttp\Psr7\Request('GET', 'https://rp76.ir');

return $client->easySend($request); // get body of response
```

## Availbe methods

| Method       | Short one                                    |
|--------------|----------------------------------------------|
|`$client->easySend($request)->getBody()` | `$client->easySend($request)->body`          |
|`$client->easySend($request)->getJson()` | `$client->easySend($request)->json`          |
|`$client->easySend($request)->getObject()` | `$client->easySend($request)->object`        |
|`$client->easySend($request)->getHeaders()` | `$client->easySend($request)->headers`       |
|`$client->easySend($request)->getHeader()` |                                              |
|`$client->easySend($request)->getRequestHeaders()` | `$client->easySend($request)->requestHeaders` |
|`$client->easySend($request)->getRequestHeader()` |                                              |
|`$client->easySend($request)->getStatusCode()` | `$client->easySend($request)->statusCode`    |
|`$client->easySend($request)->success()` |                                              |
|`$client->easySend($request)->getRequestParams()` | `$client->easySend($request)->requestParams` |
|`$client->easySend($request)->getRequestUrl()` | `$client->easySend($request)->requestUrl`    |
|`$client->easySend($request)->getEffectiveUrl()` | `$client->easySend($request)->effectiveUrl`  |
|`$client->easySend($request)->getResponseTime()` | `$client->easySend($request)->ResponseTime`  |

> **getEffectiveUrl**: return request url after _redirect_.


## License
The MIT License (MIT). Please see [License File](https://github.com/RezaParsian/Guzzle/blob/master/LICENCE) for more information.