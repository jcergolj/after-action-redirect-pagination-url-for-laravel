<?php

if (! function_exists('to_intended_route')) {
    /**
     * Create a new intended redirect response to the previously intended location.
     *
     * @param  string  $default
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @param  string  $urlSuffix
     * @return \Illuminate\Http\RedirectResponse
     */
    function to_intended_route($default, $status = 302, $headers = [], $secure = null, $urlSuffix = '')
    {
        $path = redirect()->getIntendedUrl().$urlSuffix ?? route($default);

        return redirect()->to($path, $status, $headers, $secure);
    }

    if (! function_exists('set_intended_route')) {
        /**
         * Set intended url.
         *
         * @param  string  $route
         * @return \Illuminate\Http\RedirectResponse
         */
        function set_intended_route(string $route): void
        {
            redirect()->setIntendedUrl(route($route));
        }
    }

}
