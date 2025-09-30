<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most apps will store their views here. You may customize this to
    | include any number of locations you wish to check for views.
    |
    */

    'paths' => [
        // 1. Point to the 'resources/views' inside the 'web' folder
        //    This uses base_path() which resolves from the 'backend' folder.
        base_path('../web/resources/views'),

        // 2. Keep the original 'resources/views' inside 'backend' as a fallback
        //    This is useful for any views used by the backend itself (e.g., mail).
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, we are free to change this location.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];