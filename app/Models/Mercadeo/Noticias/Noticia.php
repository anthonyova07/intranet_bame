<?php

namespace Bame\Models\Mercadeo\Noticias;

class Noticia
{
    private static $sql;

    public static function addFilter($termino)
    {
        self::$sql .= ' AND TITLE LIKE \'%' . $termino . '%\' OR DETAIL LIKE \'%' . $termino . '%\'';
    }

    public static function orderByCreatedAtAsc()
    {
        self::$sql .= ' ORDER BY CREATED_AT ASC';
    }

    public static function orderByCreatedAtDesc()
    {
        self::$sql .= ' ORDER BY CREATED_AT DESC';
    }

    public static function all($usuario)
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM INTRANET_NEWS WHERE CREATED_BY = \'' . $usuario . '\'' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        $result = collect($stmt->fetchAll());

        return $result->count() ? $result : false;
    }

    public static function create($title, $detail, $image, $type)
    {
        $id = uniqid(true);
        $title = cap_str($title);
        $detail = cap_str($detail);
        $image = clear_str($image);
        $type = $type;
        $created_by = session()->get('usuario');
        $created_at = (new \DateTime)->format('Y-m-d h:i:s');

        $sql = "INSERT INTO INTRANET_NEWS(ID, TITLE, DETAIL, IMAGE, TYPE, CREATED_BY, CREATED_AT) VALUES('{$id}', '{$title}', '{$detail}', '{$image}', '{$type}', '{$created_by}', '{$created_at}')";

        $stmt = app('con_ibs')->prepare($sql);

        $stmt->execute();
    }

    private static function getFields()
    {
        return [
            'TRIM(ID) ID',
            'TRIM(TITLE) TITLE',
            'TRIM(DETAIL) DETAIL',
            'TRIM(IMAGE) IMAGE',
            'TRIM(TYPE) TYPE',
            'TRIM(CREATED_BY) CREATED_BY',
            'TRIM(UPDATED_BY) UPDATED_BY',
            'VARCHAR_FORMAT(CREATED_AT, \'YYYY-MM-DD HH24:MI:SS\') CREATED_AT',
            'VARCHAR_FORMAT(UPDATED_AT, \'YYYY-MM-DD HH24:MI:SS\') UPDATED_AT'
        ];
    }
}
