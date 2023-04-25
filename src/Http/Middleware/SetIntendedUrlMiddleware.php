<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SetIntendedUrlMiddleware
{
    /**
     * Routes that should be excluded.
     *
     * @var array
     */
    public $excludedRoutes = [
        //
    ];

    /**
     * Routes that should be included.
     *
     * @var array
     */
    public $includedRoutes = [
        //
    ];

    public function handle(Request $request, Closure $next): mixed
    {
        $routeNameString = Str::of($request->route()->getName());

        if ($routeNameString->endsWith('.index') && ! $routeNameString->contains($this->excludedRoutes)) {
            redirect()->setIntendedUrl($request->fullUrl());
        }

        if ($routeNameString->contains($this->includedRoutes)) {
            redirect()->setIntendedUrl($request->fullUrl());
        }

        return $next($request);
    }
}
