<?php

namespace Jcergolj\AfterActionRedirectUrlForLaravel\Macros;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Jcergolj\AfterActionRedirectUrlForLaravel\Exceptions\LastPageEmpty;

class Redirector
{
    public function redirectIfLastPageEmpty()
    {
        return function (Request $request, $paginator) {
            if ($paginator instanceof LengthAwarePaginator === false) {
                return $this;
            }

            if ($request->page > 1 && $request->page > $paginator->lastPage() && $paginator->count() === 0) {
                $request->merge(['page' => $paginator->lastPage()]);
                throw new LastPageEmpty();
            }

            return $this;
        };
    }
}
