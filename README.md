# Zapheus

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Inspired from PHP frameworks of all shape and sizes, Zapheus is a web application framework with a goal to be easy to use, educational, and fully extensible to the core. Whether a simple API project or a full enterprise application, Zapheus will try to adapt it according to developer's needs.

## Install

Via Composer

``` bash
$ composer require zapheus/zapheus
```

## Usage

### Using `Coordinator`

``` php
require 'vendor/autoload.php';

// Initializes the router application
$app = new Zapheus\Coordinator;

// Creates a HTTP route of GET /
$app->get('/', function ()
{
    return 'Hello world!';
});

// Handles the server request
echo $app->run();
```

### Using `Middlelayer`

``` php
require 'vendor/autoload.php';

// Initializes the middleware application
$app = new Zapheus\Middlelayer;

// Initializes the router instance
$router = new Zapheus\Routing\Router;

// Creates a HTTP route of GET /
$router->get('/', function ()
{
    return 'Hello world!';
});

// Pipes the router middleware into the application
$app->pipe(function ($request, $next) use ($router)
{
    // Returns the request attribute value for a route
    $attribute = Zapheus\Application::ROUTE_ATTRIBUTE;

    // Returns the path from the URI instance
    $path = $request->uri()->path();

    // Returns the current HTTP method from the $_SERVER
    $method = $request->method();

    // Creates a new Routing\DispatcherInterface instance
    $dispatcher = new Zapheus\Routing\Dispatcher($router);

    // Dispatches the router against the current request
    $route = $dispatcher->dispatch($method, $path);

    // Sets the route attribute into the request in order to be
    // called inside the Application instance and return the response.
    $request = $request->push('attributes', $route, $attribute);

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