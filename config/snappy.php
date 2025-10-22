<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timeout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    'pdf' => [
        'enabled' => true,
        'binary'  => 'C:\Progra~1\wkhtmltopdf\bin\wkhtmltopdf.exe',
        'timeout' => false,
        'options' => [
        'encoding'                 => 'utf-8',
        'page-width'               => '210mm',   // F4
        'page-height'              => '330mm',   // F4
        'margin-top'               => '12mm',
        'margin-right'             => '12mm',
        'margin-bottom'            => '12mm',
        'margin-left'              => '12mm',
        'print-media-type'         => true,
        'disable-smart-shrinking'  => true,
        'enable-local-file-access' => true,
        'dpi'                      => 96,
        ],
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
