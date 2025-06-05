<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Include your relevant API paths

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | This controls which HTTP methods are allowed when making requests to your
    | application. The default is to allow all methods.
    |
    */
    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | This specifies which origins are allowed to access the resources. Make sure
    | to specify both Laravel and FastAPI frontends, or use '*' for all origins.
    |
    */
    'allowed_origins' => [
        'http://localhost:8000',     // Laravel frontend
        'http://127.0.0.1:8000',    // Alternative address for Laravel frontend
        'http://127.0.0.1:9000',    // FastAPI backend
    ],

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | This specifies which headers are allowed in the request. You can specify
    | an array of specific headers or allow all headers.
    |
    */
    'allowed_headers' => ['*'],  // Allow all headers

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify which headers should be exposed to the
    | browser. By default, no headers are exposed.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | This option defines the maximum age (in seconds) of the preflight request
    | cache. This means the browser won't need to send preflight requests for
    | this amount of time.
    |
    */
    'max_age' => 0,  // Set to a positive integer for caching if needed

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | This option determines whether or not cookies and authentication headers
    | are allowed in cross-origin requests.
    |
    */
    'supports_credentials' => false,  // Set to true if you want to allow cookies/auth headers

];
