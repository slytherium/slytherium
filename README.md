# Slytherium

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Slytherium is yet another simple and extensible micro-framework for PHP. This package supercedes and replaces [Slytherin](https://github.com/rougin/slytherin).

## Install

Via Composer

``` bash
$ composer require slytherium/slytherium
```

Want to use this framework on PHP v5.2.0 and below? Use the [Legacy](https://github.com/slytherium/legacy) package instead.

## Usage

**Hello.php**

``` php
class HelloController
{
    public function greet($name = 'Stranger')
    {
        return sprintf('Hello, %s!', $name);
    }
}
```

### Using `Application\Router`

**index.php**

``` php
use Slytherium\Http\Message\ServerRequestInterface;

// Creates the server request instance
$request = new Slytherium\Http\Message\ServerRequest($_SERVER);

// Initializes the router application
$app = new Slytherium\Application\Router;

// Sets the server request inside the application
$app->set(ServerRequestInterface::class, $request);

// Defines the HelloController instance
$app->set(HelloController::class, new HelloController);

// Creates a HTTP route of GET /
$app->get('/', 'HelloController@greet');

// Creates a HTTP route of GET /hello/{name}
$app->get('/hello/{name}', 'HelloController@greet');

// Runs the application
echo $app->run();
```

### Using `Application\Middleware`

**RouterMiddleware.php**

``` php
use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\HandlerInterface;
use Slytherium\Http\Server\MiddlewareInterface;
use Slytherium\Routing\Dispatcher;

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
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @param  \Slytherium\Http\Server\HandlerInterface        $handler
     * @return \Slytherium\Http\Message\ResponseInterface
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
     * Returns the \Slytherium\Routing\Router instance.
     *
     * @return \Slytherium\Routing\RouterInterface
     */
    protected function router()
    {
        // Initializes the HTTP router
        $router = new Slytherium\Routing\Router;

        // Creates a HTTP route of GET /
        $router->get('/', 'HelloController@greet');

        // Creates a HTTP route of GET /hello/{name}
        $router->get('/hello/{name}', 'HelloController@greet');

        return $router;
    }
}
```

**index.php**

``` php
use Slytherium\Http\Message\ServerRequestInterface;

// Creates the server request instance
$request = new Slytherium\Http\Message\ServerRequest($_SERVER);

// Initializes the middleware application
$app = new Slytherium\Application\Middleware;

// Sets the server request inside the application
$app->set(ServerRequestInterface::class, $request);

// Defines the HelloController instance
$app->set(HelloController::class, new HelloController);

// Pipes the router middleware into the application
$app->pipe(new RouterMiddleware);

// Runs the application
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

[ico-version]: https://img.shields.io/packagist/v/slytherium/slytherium.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/slytherium/slytherium/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/slytherium/slytherium.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/slytherium/slytherium.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/slytherium/slytherium.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/slytherium/slytherium
[link-travis]: https://travis-ci.org/slytherium/slytherium
[link-scrutinizer]: https://scrutinizer-ci.com/g/slytherium/slytherium/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/slytherium/slytherium
[link-downloads]: https://packagist.org/packages/slytherium/slytherium
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors
