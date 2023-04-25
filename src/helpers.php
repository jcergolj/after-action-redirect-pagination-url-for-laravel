<?php

if (! function_exists('to_intended_route')) {
    /**
     * Create a new intended redirect response to the previously intended location.
     *
     * @param  string  $default
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    function to_intended_route($route, $status = 302, $headers = [], $secure = null)
    {
        return redirect()->intended(route($route), $status, $headers, $secure);
    }
}
