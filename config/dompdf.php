<?php

return [

    'show_warnings' => false,

    'orientation' => 'portrait',

    'defines' => [
        "font_dir" => resource_path('fonts/'),
        "font_cache" => storage_path('fonts/'),
        "temp_dir" => sys_get_temp_dir(),
        "chroot" => realpath(base_path()),

        "default_media_type" => "screen",
        "default_paper_size" => "a4",
        "default_font" => "cairo",

        "dpi" => 96,
        "enable_php" => false,
        "enable_javascript" => true,
        "enable_html5_parser" => true,

        "fonts" => [
            "cairo" => [
                'R' => "Cairo-Regular.ttf",
                'B' => "Cairo-Bold.ttf",
                'useOTL' => 0,
                'useKashida' => 75,
            ],
        ],
    ],
];
