<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Tests\Unit\Exceptions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadeRoute;
use Jcergolj\AfterActionRedirectUrlForLaravel\Exceptions\LastPageEmpty;
use Jcergolj\AfterActionRedirectUrlForLaravel\Tests\TestCase;

/** @see Jcergolj\AfterActionRedirectUrlForLaravel\Exceptions\LastPageEmpty */
class LastPageEmptyTest extends TestCase
{
    /** @test */
    public function render()
    {
        FacadeRoute::get('/')->name('users.index');
        $request = new Request();

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', 'users', [
                'as' => 'users.index',
            ]);

            $route->bind($request);

            return $route;
        });

        $lastPageEmpty = new LastPageEmpty($request);

        $response = $lastPageEmpty->render($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);

        $this->assertSame($response->getStatusCode(), Response::HTTP_FOUND);
    }
}
