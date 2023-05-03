<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Tests\Unit\Macros;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Jcergolj\AfterActionRedirectUrlForLaravel\Exceptions\LastPageEmpty;
use Jcergolj\AfterActionRedirectUrlForLaravel\Macros\Redirector as MacroRedirector;
use Jcergolj\AfterActionRedirectUrlForLaravel\Tests\TestCase;
use stdClass;

/** @see Jcergolj\AfterActionRedirectUrlForLaravel\Macros\Redirector */
class RedirectorTest extends TestCase
{
    /** @var Request */
    public $request;

    /** @var LengthAwarePaginator */
    public $lengthAwarePaginator;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();

        $this->request->setRouteResolver(function () {
            $route = new Route('GET', 'users', [
                'as' => 'users.index',
            ]);

            $route->bind($this->request);

            return $route;
        });

        $this->lengthAwarePaginator = new LengthAwarePaginator(collect([]), 1, 1, 1);

        Redirect::mixin(new MacroRedirector());
    }

    /** @test */
    public function throw_last_page_empty_exception_if_page_is_two_but_last_page_does_not_have_any_items()
    {
        $this->expectException(LastPageEmpty::class);

        $this->request->merge(['page' => 2]);

        redirect()->redirectIfLastPageEmpty($this->request, $this->lengthAwarePaginator);
    }

    /** @test */
    public function do_not_throw_exception_if_page_is_null()
    {
        $this->request->merge(['page' => null]);

        $this->assertInstanceOf(Redirector::class, redirect()->redirectIfLastPageEmpty($this->request, $this->lengthAwarePaginator));
    }

    /** @test */
    public function do_not_throw_exception_if_count_is_greater_than_zero()
    {
        $this->request->merge(['page' => 2]);

        $this->lengthAwarePaginator = new LengthAwarePaginator(collect([1]), 1, 1, 1);

        $this->assertInstanceOf(Redirector::class, redirect()->redirectIfLastPageEmpty($this->request, $this->lengthAwarePaginator));
    }

    /** @test */
    public function do_not_throw_exception_if_last_page_is_greater_than_page()
    {
        $this->request->merge(['page' => 2]);

        $this->lengthAwarePaginator = new LengthAwarePaginator(collect([]), 2, 1, 1);

        $this->assertInstanceOf(Redirector::class, redirect()->redirectIfLastPageEmpty($this->request, $this->lengthAwarePaginator));
    }

    /** @test */
    public function do_not_throw_exception_if_page_is_one()
    {
        $this->request->merge(['page' => 1]);

        $this->assertInstanceOf(Redirector::class, redirect()->redirectIfLastPageEmpty($this->request, $this->lengthAwarePaginator));
    }

    /** @test */
    public function do_not_throw_exception_if_class_is_not_length_aware_paginator()
    {
        $this->request->merge(['page' => 2]);

        $this->assertInstanceOf(Redirector::class, redirect()->redirectIfLastPageEmpty($this->request, new stdClass));
    }
}
