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

Want to use this framework on PHP v5.2.0 and below? Use the [Legacy](https://github.com/zapheus/legacy) package instead.

## Usage

**GreetController.php**

``` php
class GreetController
{
    public function greet($name = 'Stranger')
    {
        return sprintf('Hello, %s!', $name);
    }
}
```

### Using `RouterApplication`

**index.php**

``` php
require 'vendor/autoload.php';
require 'GreetController.php';

use Zapheus\Application\RouterApplication;

// Initializes the router application
$app = new RouterApplication;

// Creates a HTTP route of GET /
$app->get('/', 'GreetController@greet');

// Creates a HTTP route of GET /hello/{name}
$app->get('/hello/{name}', 'GreetController@greet');

// Handles the server request
echo $app->run();
```

### Using `MiddlewareApplication`

**RouterMiddleware.php**

``` php
use Zapheus\Application;
use Zapheus\Http\Message\ServerRequestInterface;
use Zapheus\Http\Server\HandlerInterface;
use Zapheus\Http\Server\MiddlewareInterface;
use Zapheus\Routing\Dispatcher;

class RouterMiddleware implements MiddlewareInterface
{
    /**
     * Returns the resolver attribute constant from the Application.
     *
     * @var string
     */
    protected $attribute = Application::RESOLVER_ATTRIBUTE;

    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface        $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        // Returns the path from the URI instance
        $path = $request->getUri()->getPath();

        // Returns the current HTTP method from the $_SERVER
        $method = $request->getMethod();

        // Creates the router dispatcher instance 
        $dispatcher = new Dispatcher($this->router());

        // Dispatches the router against the current HTTP method and URI
        $resolver = $dispatcher->dispatch($method, $path);

        // Sets the resolver attribute into the request in order to be
        // called inside the Application instance and return the response.
        $request = $request->withAttribute($this->attribute, $resolver);

        // Handles the next middleware
        return $handler->handle($request);
    }

    /**
     * Returns the \Zapheus\Routing\Router instance.
     *
     * @return \Zapheus\Routing\RouterInterface
     */
    protected function router()
    {
        // Initializes the HTTP router
        $router = new Zapheus\Routing\Router;

        // Creates a HTTP route of GET /
        $router->get('/', 'GreetController@greet');

        // Creates a HTTP route of GET /hello/{name}
        $router->get('/hello/{name}', 'GreetController@greet');

        return $router;
    }
}
```

**index.php**

``` php
require 'vendor/autoload.php';
require 'GreetController.php';
require 'RouterMiddleware.php';

use Zapheus\Application\MiddlewareApplication;

// Initializes the middleware application
$app = new MiddlewareApplication;

// Pipes the router middleware into the application
$app->pipe(new RouterMiddleware);

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