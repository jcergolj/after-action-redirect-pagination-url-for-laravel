<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;
use Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware\SetIntendedUrlMiddleware;
use Jcergolj\AfterActionRedirectUrlForLaravel\Macros\Redirector as MacroRedirector;
use ReflectionClass;

class AfterActionRedirectUrlForLaravelServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        if (class_exists(\App\Http\Middleware\SetIntendedUrlMiddleware::class) && $this->isSubclass()) {
            $kernel->appendMiddlewareToGroup('web', \App\Http\Middleware\SetIntendedUrlMiddleware::class);
        } else {
            $kernel->appendMiddlewareToGroup(
                'web',
                SetIntendedUrlMiddleware::class
            );
        }

        Redirector::mixin(new MacroRedirector());
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
