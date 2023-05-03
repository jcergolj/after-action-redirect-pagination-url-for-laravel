### Why
The After Action Redirect Pagination URL for Laravel package provides a solution for two issues that developers may encounter when working with pagination in their Laravel application. These issues include [losing query parameters and the current page when editing an item and being redirected to the first page of the index](#saving-and-redirecting-to-last-index-url-with-query-parameters), as well as being [redirected to an empty last page after deleting the last item on the last page](#redirect-to-last-page-with-items-after-deleting-last-item-on-last-page).

### Installation
```bash
composer require jcergolj/after-action-redirect-pagination-url-for-laravel
```

### Saving and Redirecting to Last Index URL with Query Parameters
This package allows you to save the full URL, including any query parameters, of the index page in the intended URL session. After a create or update action, you can use the `to_intended_route` helper method to be redirected to the same page. You can also include or exclude routes from the intended URL saving mechanism for greater customization.

To use this feature, add the following code to your controller:
```php
    return to_intended_route('users.index');
```
By default, `to_intended_route` will redirect to the last intended URL. If no URL was intended, it will redirect to the users.index route.

Example:
```php
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

#### Include and Exclude routes
To include or exclude routes from the intended URL saving mechanism, create a `SetIntendedUrlMiddleware` class in the App\Http\Middleware namespace. In this class, you can specify the routes that should be excluded or included using the `$excludedRoutes` and `$includedRoutes` arrays.
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

### Redirect to Last Page with Items after Deleting Last Item on Last Page
When you delete the last item on the last page of your Laravel app, you may encounter an issue where you are redirected to an empty last page. The After Action Redirect Pagination URL for Laravel package solves this problem by redirecting you to the last page with items.

To use this feature, add the following code after your paginated query:

```php
redirect()->redirectIfLastPageEmpty($request, /** paginated results */);
```

This will check whether there are any items on the last page of your paginated results. If there are no items, it will redirect you to the last page that has items.

Here is an example of how you might use this in your controller's index method:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        // continue executing the code, or redirect back with page set to paginator last page
        redirect()->redirectIfLastPageEmpty($request, $users);

        return view('users.index', [
            'users' => $users,
        ]);
    }
}
```
