<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Tests;

use Jcergolj\AfterActionRedirectUrlForLaravel\AfterActionRedirectUrlForLaravelServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AfterActionRedirectUrlForLaravelServiceProvider::class,
        ];
    }
}
