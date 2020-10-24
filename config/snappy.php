<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        // 'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltopdf-amd64'),

        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        // 'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"',

        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

    // 'binary'  => '/usr/local/bin/wkhtmltopdf-amd64',
    //'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',

    // 'binary'  => '/usr/local/bin/wkhtmltoimage-amd64',
    //'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"',

);
