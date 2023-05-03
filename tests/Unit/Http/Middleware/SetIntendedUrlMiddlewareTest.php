<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware\SetIntendedUrlMiddleware;
use Jcergolj\AfterActionRedirectUrlForLaravel\Tests\TestCase;

/** @see Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware\SetIntendedUrlMiddleware */
class SetIntendedUrlMiddlewareTest extends TestCase
{
    /** @test */
    public function if_it_is_index_page_save_intend_url()
    {
        $request = new Request();
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', 'users', [
                'as' => 'users.index',
            ]);

            $route->bind($request);

            return $route;
        });

        $this->assertNull(redirect()->getIntendedUrl());

        $middleware = new SetIntendedUrlMiddleware();

        $expectedResponse = new Response('allowed', Response::HTTP_OK);
        $next = function () use ($expectedResponse) {
            return $expectedResponse;
        };

        $actualResponse = $middleware->handle($request, $next);

        $this->assertSame($expectedResponse, $actualResponse);
        $this->assertSame('http://:', redirect()->getIntendedUrl());
    }

    /** @test */
    public function include_route_page_save_intend_url()
    {
        $request = new Request();
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', 'users', [
                'as' => 'include.route',
                'prefix' => 'http://dsfaasf',
            ]);

            $route->bind($request);

            return $route;
        });

        $this->assertNull(redirect()->getIntendedUrl());

        $middleware = new SetIntendedUrlMiddleware();
        $middleware->includedRoutes = ['include.route'];

        $expectedResponse = new Response('allowed', Response::HTTP_OK);
        $next = function () use ($expectedResponse) {
            return $expectedResponse;
        };

        $actualResponse = $middleware->handle($request, $next);

        $this->assertSame($expectedResponse, $actualResponse);
        $this->assertSame('http://:', redirect()->getIntendedUrl());
    }

    /** @test */
    public function exclude_route_page_save_intend_url()
    {
        $request = new Request();
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', 'users', [
                'as' => 'users.index',
                'prefix' => 'http://dsfaasf',
            ]);

            $route->bind($request);

            return $route;
        });

        $this->assertNull(redirect()->getIntendedUrl());

        $middleware = new SetIntendedUrlMiddleware();
        $middleware->excludedRoutes = ['users.index'];

        $expectedResponse = new Response('allowed', Response::HTTP_OK);
        $next = function () use ($expectedResponse) {
            return $expectedResponse;
        };

        $actualResponse = $middleware->handle($request, $next);

        $this->assertSame($expectedResponse, $actualResponse);

        $this->assertNull(redirect()->getIntendedUrl());
    }

    /** @test */
    public function if_it_is_not_an_index_page_continue()
    {
        $request = new Request();
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', 'users/create', [
                'as' => 'users.create',
            ]);

            $route->bind($request);

            return $route;
        });

        $this->assertNull(redirect()->getIntendedUrl());

        $middleware = new SetIntendedUrlMiddleware();

        $expectedResponse = new Response('allowed', Response::HTTP_OK);
        $next = function () use ($expectedResponse) {
            return $expectedResponse;
        };

        $actualResponse = $middleware->handle($request, $next);

        $this->assertSame($expectedResponse, $actualResponse);

        $this->assertNull(redirect()->getIntendedUrl());
    }

    /** @test */
    public function assert_middleware_is_applied_for_web_routes()
    {
        $router = $this->app->make(Router::class);
        $this->assertTrue(in_array(SetIntendedUrlMiddleware::class, $router->getMiddlewareGroups()['web']));
    }
}
