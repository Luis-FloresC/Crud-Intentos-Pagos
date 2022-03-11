<?php

namespace Dao\Personas;

use Dao\Table;

class Personas extends Table
{


    public static function obtenerTodos()
    {
        $sqlstr = "select * from Personas;";
        return self::obtenerRegistros($sqlstr, array());
    }


    public static function obtenerPorId($id)
    {
        $sqlstr = "select * from Personas where id = :id;";
        return self::obtenerUnRegistro($sqlstr, array("id" => $id));
    }


    public static function nuevoRegistro($identidad, $nombre, $edad)
    {
        $sqlstr = "INSERT INTO Personas (identidad,nombre,edad) values (:identidad,:nombre,:edad);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "identidad" => $identidad,
                "nombre" => $nombre,
                "edad" => $edad,
            )
        );
    }


    public static function editarRegistro($id, $identidad, $nombre, $edad)
    {
        $sqlstr = "UPDATE Personas set identidad = :identidad,identidad = :identidad,nombre = :nombre,edad = :edad where id = :id";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "id" => $id,
                "identidad" => $identidad,
                "nombre" => $nombre,
                "edad" => $edad,
            )
        );
    }


    public static function eliminarRegistro($id)
    {
        $sqlstr = "DELETE FROM Personas where id = :id;";
        return self::executeNonQuery($sqlstr, array("id" => $id));
    }
}
