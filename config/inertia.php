<?php

return [

    /*
    | Page components live in resources/js/Pages (capital P). The package
    | default is lowercase "pages", which fails on case-sensitive file systems
    | when tests assert that a page component exists.
    */

    'pages' => [

        'ensure_pages_exist' => false,

        'paths' => [
            resource_path('js/Pages'),
        ],

        'extensions' => ['js', 'jsx', 'ts', 'tsx'],

    ],

    'testing' => [

        'ensure_pages_exist' => true,

    ],

];
