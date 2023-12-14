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
    function to_intended_route($default, $status = 302, $headers = [], $secure = null)
    {
        $path = redirect()->getIntendedUrl() ?? route($default);

        return redirect()->to($path, $status, $headers, $secure);
    }
}
