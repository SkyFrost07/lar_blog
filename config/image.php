<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    
    'paths' => [ '../../thumbnail/', '../../medium/', '../../large', '../../full'],
    'prepends' => [],
    'appends' => [],
    'widths' => [80, 300, 600, ''],
    'heights' => [80, 200, '', ''],
    'options' => ['crop', 'crop', 'auto', 'auto']

);
