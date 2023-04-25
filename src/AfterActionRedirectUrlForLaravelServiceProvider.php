<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware\SetIntendedUrlMiddleware;
use ReflectionClass;

class AfterActionRedirectUrlForLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $router = $this->app->make(Router::class);

        if (class_exists(\App\Http\Middleware\SetIntendedUrlMiddleware::class) && $this->isSubclass()) {
            $router->pushMiddlewareToGroup('web', \App\Http\Middleware\SetIntendedUrlMiddleware::class);
        } else {
            $router->pushMiddlewareToGroup(
                'web',
                SetIntendedUrlMiddleware::class
            );
        }
    }

    public function register()
    {

    }

    protected function isSubclass()
    {
        $customSetIntendedUrlMiddleware = new ReflectionClass(\App\Http\Middleware\SetIntendedUrlMiddleware::class);
        $packageSetIntendedUrlMiddleware = new ReflectionClass(SetIntendedUrlMiddleware::class);

        return $customSetIntendedUrlMiddleware->isSubclassOf($packageSetIntendedUrlMiddleware);
    }
}
