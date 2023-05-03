<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Exceptions;

use Exception;
use Illuminate\Http\Request;

class LastPageEmpty extends Exception
{
    public function render(Request $request)
    {
        return redirect()->route($request->route()->getName(), $request->all());
    }
}
