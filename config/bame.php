<?php

return [

    'encartes' => [
        'carpeta_pdf' => env('ENCARTES_CARPETA_PDF'),
        'carpeta_foto' => env('ENCARTES_CARPETA_FOTO'),
        'cantidad_x_archivo' => env('ENCARTE_CANTIDAD_POR_ARCHIVO'),
    ],

    'ncf' => [
        'carpeta_pdf' => env('NCF_CARPETA_PDF'),
    ],

    'notificaciones' => [
        'internvalo' => env('NOTIFICACIONES_INTERVALO'),
        'expiracion' => env('NOTIFICATION_EXPIRATIONS_MINUTES'),
    ],

    'log_max_rows' => env('LOG_MAX_ROWS'),

    'banners_quantity' => env('BANNERS_QUANTITY'),

    'news_quantity' => env('NEWS_QUANTITY'),

    'js' => [
        'not_cache' => env('JS_NOT_CACHE'),
    ],

    'mantenance_need_approvals' => env('MAINTENANCE_NEED_APPROVALS'),

    'links' => [
        'codigo_etica' => env('LINK_CODIGO_ETICA', '#'),
        'normativa_legal' => env('LINK_NORMATIVA_LEGAL', '#'),
    ],

    'timeout' => [
        'logout' => env('TIMEOUT_LOGOUT', 180000),
    ],

    'employee' => [
        'bulk_load' => env('EMPLOYEE_BULK_LOAD', 'false'),
    ],

    'requests' => [
        'db' => [
            'url' => env('REQUEST_TDC_URL', 'C:\xampp\htdocs\intranet\storage\app\db_requests\\'),
        ],
    ],

];
