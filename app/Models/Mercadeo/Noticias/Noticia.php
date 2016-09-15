<?php

namespace Bame\Models\Mercadeo\Noticias;

class Noticia
{
    private static $sql;

    public static function addFilter($termino)
    {
        self::$sql .= ' AND TITLE LIKE \'%' . cap_str($termino) . '%\' OR DETAIL LIKE \'%' . clear_str($termino) . '%\'';
    }

    public static function addCreatedAtFromFilter($fecha_desde)
    {
        self::$sql .= ' AND CREATED_AT >= \'' . $fecha_desde . ' 00:00:00\'';
    }

    public static function addCreatedAtToFilter($fecha_hasta)
    {
        self::$sql .= ' AND CREATED_AT <= \'' . $fecha_hasta . ' 23:59:59\'';
    }

    public static function orderByCreatedAtAsc()
    {
        self::$sql .= ' ORDER BY CREATED_AT ASC';
    }

    public static function orderByCreatedAtDesc()
    {
        self::$sql .= ' ORDER BY CREATED_AT DESC';
    }

    public static function take($cantidad) {
        self::$sql .= ' FETCH FIRST ' . $cantidad . ' ROWS ONLY';
    }

    public static function getById($id) {
        $sql = "SELECT " . implode(", ", self::getFields()) . " FROM INTRANET_NEWS WHERE ID = '{$id}'";
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getLastNewColumn() {
        self::orderByCreatedAtDesc();
        self::take(1);

        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM INTRANET_NEWS WHERE TYPE = \'C\'' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getLastBanners($cantidad) {
        self::orderByCreatedAtDesc();
        self::take($cantidad);

        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM INTRANET_NEWS WHERE TYPE = \'B\'' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return collect($stmt->fetchAll());
    }

    public static function getLastNews($cantidad) {
        self::orderByCreatedAtDesc();
        self::take($cantidad);

        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM INTRANET_NEWS WHERE TYPE = \'N\'' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return collect($stmt->fetchAll());
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

    public static function create($id, $title, $detail, $image, $type)
    {
        $title = cap_str($title);
        $detail = trim(nl2br($detail));
        $image = $image;
        $type = $type;
        $created_by = session()->get('usuario');
        $created_at = (new \DateTime)->format('Y-m-d h:i:s');

        $sql = "INSERT INTO INTRANET_NEWS(ID, TITLE, DETAIL, IMAGE, TYPE, CREATED_BY, CREATED_AT) VALUES('{$id}', '{$title}', '{$detail}', '{$image}', '{$type}', '{$created_by}', '{$created_at}')";

        $stmt = app('con_ibs')->prepare($sql);

        $stmt->execute();
    }

    public static function update($id, $title, $detail, $type)
    {
        $title = cap_str($title);
        $detail = trim(nl2br($detail));
        $type = $type;
        $updated_by = session()->get('usuario');
        $updated_at = (new \DateTime)->format('Y-m-d h:i:s');

        $sql = "UPDATE INTRANET_NEWS SET TITLE = '{$title}', DETAIL = '{$detail}', TYPE = '{$type}', UPDATED_BY = '{$updated_by}', UPDATED_AT = '{$updated_at}' WHERE ID = '{$id}'";

        $stmt = app('con_ibs')->prepare($sql);

        $stmt->execute();
    }

    public static function delete($usuario, $id, $image) {
        $sql = 'DELETE FROM INTRANET_NEWS WHERE CREATED_BY = \'' . $usuario . '\' AND ID = \'' . $id . '\'';

        $stmt = app('con_ibs')->prepare($sql);

        if ($stmt->execute()) {
            unlink(public_path() . '\\mercadeo\\images\\' . $image);
        }
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
