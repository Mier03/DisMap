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
        // CORRECTED PATH: Use the application's base path and go up to the main root (/app)
        // then look for the sibling 'web' folder structure.
        realpath(__DIR__.'/../../web/resources/views'), 
        
        // OR, the simpler form that relies on the structure:
        // base_path('../web/resources/views'), 
        // We will stick to your relative path but ensure the config cache is cleared.
        base_path('../web/resources/views'),

        // Keep the original 'resources/views' inside 'backend' as a fallback
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