<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_spanish_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ],

        'sqlsrv_ibtrxs' => [
            'driver' => 'sqlsrv',
            'host' => env('IB_IP'),
            'database' => env('IB_DB_TRX'),
            'username' => env('IB_USR'),
            'password' => env('IB_PASS'),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        'sqlsrv_ibcustomers' => [
            'driver' => 'sqlsrv',
            'host' => env('IB_IP'),
            'database' => env('IB_DB_CUSTOMER'),
            'username' => env('IB_USR'),
            'password' => env('IB_PASS'),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        //inteligencia artificial
        'sqlsrv_bi' => [
            'driver' => 'sqlsrv',
            'host' => env('BI_IP'),
            'database' => env('BI_DB'),
            'username' => env('BI_USR'),
            'password' => env('BI_PASS'),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        /*
       |--------------------------------------------------------------------------
       | DB2 Databases
       | drivers 'odbc' / 'ibm' / 'odbczos'
       | driverNames '{IBM i Access ODBC Driver}' / '{iSeries Access ODBC Driver}'
       |--------------------------------------------------------------------------
       */

       'ibs' => [
           'driver'               => 'odbc',
           'driverName'           => '{iSeries Access ODBC Driver}',
            // General settings
           'host'                 => env('IBS_IP'),
           'username'             => env('IBS_USR'),
           'password'             => env('IBS_PASS'),
           //Server settings
           'database'             => env('IBS_DB'),
           'prefix'               => '',
           'schema'               => env('IBS_DB'),
           'port'                 => 50000,
           'signon'               => 3,
           'ssl'                  => 0,
           'commitMode'           => 2,
           'connectionType'       => 0,
           'defaultLibraries'     => '',
           'naming'               => 0,
           'unicodeSql'           => 0,
           // Format settings
           'dateFormat'           => 5,
           'dateSeperator'        => 0,
           'decimal'              => 0,
           'timeFormat'           => 0,
           'timeSeparator'        => 0,
           // Performances settings
           'blockFetch'           => 1,
           'blockSizeKB'          => 32,
           'allowDataCompression' => 1,
           'concurrency'          => 0,
           'lazyClose'            => 0,
           'maxFieldLength'       => 15360,
           'prefetch'             => 0,
           'queryTimeout'         => 1,
           // Modules settings
           'defaultPkgLibrary'    => 'QGPL',
           'defaultPackage'       => 'A/DEFAULT(IBM),2,0,1,0',
           'extendedDynamic'      => 1,
           // Diagnostic settings
           'QAQQINILibrary'       => '',
           'sqDiagCode'           => '',
           // Sort settings
           'languageId'           => 'ENU',
           'sortTable'            => '',
           'sortSequence'         => 0,
           'sortWeight'           => 0,
           'jobSort'              => 0,
           // Conversion settings
           'allowUnsupportedChar' => 0,
           'ccsid'                => 1208,
           'graphic'              => 0,
           'forceTranslation'     => 0,
           // Other settings
           'allowProcCalls'       => 0,
           'DB2SqlStates'         => 0,
           'debug'                => 0,
           'trueAutoCommit'       => 0,
           'catalogOptions'       => 3,
           'libraryView'          => 0,
           'ODBCRemarks'          => 0,
           'searchPattern'        => 1,
           'translationDLL'       => '',
           'translationOption'    => 0,
           'maxTraceSize'         => 0,
           'multipleTraceFiles'   => 1,
           'trace'                => 0,
           'traceFilename'        => '',
           'extendedColInfo'      => 0,
           'options'  => [
               PDO::ATTR_CASE => PDO::CASE_LOWER,
               PDO::ATTR_EMULATE_PREPARES => false,
               PDO::ATTR_PERSISTENT => true
           ]
       ],

       'itc' => [
           'driver'               => 'odbc',
           'driverName'           => '{iSeries Access ODBC Driver}',
            // General settings
           'host'                 => env('ITC_IP'),
           'username'             => env('ITC_USR'),
           'password'             => env('ITC_PASS'),
           //Server settings
           'database'             => env('ITC_DB'),
           'prefix'               => '',
           'schema'               => env('ITC_DB'),
           'port'                 => 50000,
           'signon'               => 3,
           'ssl'                  => 0,
           'commitMode'           => 2,
           'connectionType'       => 0,
           'defaultLibraries'     => '',
           'naming'               => 0,
           'unicodeSql'           => 0,
           // Format settings
           'dateFormat'           => 5,
           'dateSeperator'        => 0,
           'decimal'              => 0,
           'timeFormat'           => 0,
           'timeSeparator'        => 0,
           // Performances settings
           'blockFetch'           => 1,
           'blockSizeKB'          => 32,
           'allowDataCompression' => 1,
           'concurrency'          => 0,
           'lazyClose'            => 0,
           'maxFieldLength'       => 15360,
           'prefetch'             => 0,
           'queryTimeout'         => 1,
           // Modules settings
           'defaultPkgLibrary'    => 'QGPL',
           'defaultPackage'       => 'A/DEFAULT(IBM),2,0,1,0',
           'extendedDynamic'      => 1,
           // Diagnostic settings
           'QAQQINILibrary'       => '',
           'sqDiagCode'           => '',
           // Sort settings
           'languageId'           => 'ENU',
           'sortTable'            => '',
           'sortSequence'         => 0,
           'sortWeight'           => 0,
           'jobSort'              => 0,
           // Conversion settings
           'allowUnsupportedChar' => 0,
           'ccsid'                => 1208,
           'graphic'              => 0,
           'forceTranslation'     => 0,
           // Other settings
           'allowProcCalls'       => 0,
           'DB2SqlStates'         => 0,
           'debug'                => 0,
           'trueAutoCommit'       => 0,
           'catalogOptions'       => 3,
           'libraryView'          => 0,
           'ODBCRemarks'          => 0,
           'searchPattern'        => 1,
           'translationDLL'       => '',
           'translationOption'    => 0,
           'maxTraceSize'         => 0,
           'multipleTraceFiles'   => 1,
           'trace'                => 0,
           'traceFilename'        => '',
           'extendedColInfo'      => 0,
           'options'  => [
               PDO::ATTR_CASE => PDO::CASE_LOWER,
               PDO::ATTR_EMULATE_PREPARES => false,
               PDO::ATTR_PERSISTENT => true
           ]
       ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
