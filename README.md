# Zapheus

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An independent and framework-friendly PHP micro-framework.

## Install

Via Composer

``` bash
$ composer require zapheus/zapheus
```

## Usage

### Using `RouterApplication`

``` php
require 'vendor/autoload.php';

use Zapheus\Application\RouterApplication;

// Initializes the router application
$app = new RouterApplication;

// Creates a HTTP route of GET /
$app->get('/', function ()
{
    return 'Hello world!';
});

// Handles the server request
echo $app->run();
```

### Using `MiddlewareApplication`

``` php
require 'vendor/autoload.php';

use Zapheus\Application\MiddlewareApplication;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Router;

// Initializes the middleware application
$app = new MiddlewareApplication;

// Pipes the router middleware into the application
$app->pipe(function ($request, $next)
{
    // Creates a HTTP route of GET /
    $router = (new Router)->get('/', function ()
    {
        return 'Hello world!';
    });

    // Returns the request attribute value for resolvers
    $attribute = Zapheus\Application::RESOLVER_ATTRIBUTE;

    // Returns the path from the URI instance
    $path = $request->uri()->path();

    // Returns the current HTTP method from the $_SERVER
    $method = $request->method();

    // Dispatches the router against the current HTTP method and URI
    $resolver = (new Dispatcher($router))->dispatch($method, $path);

    // Sets the resolver attribute into the request in order to be
    // called inside the Application instance and return the response.
    $request = $request->push('attributes', $resolver, $attribute);

    // Go to the next middleware, if there are any
    return $next->handle($request);
});

// Handles the server request
echo $app->run();
```

### Run the application using PHP's built-in web server:

``` bash
$ php -S localhost:8000
```

Open your web browser and go to [http://localhost:8000](http://localhost:8000).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zapheus/zapheus.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zapheus/zapheus/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zapheus/zapheus.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zapheus/zapheus.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zapheus/zapheus.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zapheus/zapheus
[link-travis]: https://travis-ci.org/zapheus/zapheus
[link-scrutinizer]: https://scrutinizer-ci.com/g/zapheus/zapheus/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zapheus/zapheus
[link-downloads]: https://packagist.org/packages/zapheus/zapheus
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors