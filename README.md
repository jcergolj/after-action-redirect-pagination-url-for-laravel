# Why
If you've used pagination in your Laravel app, you might have encountered an annoying issue: when you edit an item, you get redirected to the first page of the index, losing your current page and query parameters. Fortunately, After Action Redirect Pagination URL for Laravel solves this problem.

After Action Redirect Pagination URL for Laravel is a simple package that solves this problem. It saves the full URL (including any of query parameters) of the index page in the intended URL session, and redirects you to that same page after a CREATE or UPDATE action. All you have to do is use the `to_intended_route` helper method, and you'll be taken back to where you left off.

But that's not all. After Action Redirect Pagination URL for Laravel also allows you to include or exclude routes from the intended URL saving mechanism, so you can fine-tune its behaviour to your specific needs.

# Installation
```bash
composer require jcergolj/after-action-redirect-pagination-url-for-laravel
```

# Usage
When on index page the full url is saved into intended session.
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::paginate(10),
        ]);
    }

    public function update(Request $request, User $token)
    {
        $user->update([...]);

        return to_intended_route('users.index');
    }
}
```

`return to_intended_route('users.index');` redirects to last intended url, if not assigned it is going to redirect to users.index route.

# Include and Exclude routes
If you wish to include or exclude routes form saving intended url, just create a `SetIntendedUrlMiddleware` class in App\Http\Middleware namespace.
```php
<?php

namespace App\Http\Middleware;

use Jcergolj\AfterActionRedirectUrlForLaravel\Http\Middleware\SetIntendedUrlMiddleware as Middleware;

class SetIntendedUrlMiddleware extends Middleware
{
    /**
     * Routes that should be excluded.
     * @var array
     */
    public $excludedRoutes = [
    ];

    /**
     * Routes that should be included.
     * @var array
     */
    public $includedRoutes = [
    ];
}
```
