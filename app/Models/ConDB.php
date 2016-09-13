<?php

namespace Bame\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;

class ConDB extends Model
{
    private static $_connectionIBS = null;
    private static $_connectionITC = null;

    public static function getConDBIBS() {
        if (self::$_connectionIBS === null) {
            self::$_connectionIBS = new PDO('odbc:' . env('ODBC_DSN_IBS'), env('ODBC_USR_IBS'), env('ODBC_PASS_IBS'));
            self::$_connectionIBS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_connectionIBS->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$_connectionIBS;
    }

    public static function getConDBITC() {
        if (self::$_connectionITC === null) {
            self::$_connectionITC = new PDO('odbc:' . env('ODBC_DSN_ITC'), env('ODBC_USR_ITC'), env('ODBC_PASS_ITC'));
            self::$_connectionITC->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_connectionITC->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$_connectionITC;
    }
}
