<?php

namespace Dao\LugaresTuristicos;

use Dao\Table;

/*

CREATE TABLE `lugaresturisticos` (
  `lugarid` bigint(18) NOT NULL AUTO_INCREMENT,
  `lugar` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `latitud` float DEFAULT NULL,
  `longitud` float DEFAULT NULL,
  PRIMARY KEY (`lugarid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

*/
class LugaresTuristicos extends Table
{
    public static function obtenerTodos()
    {
        $sqlstr = "select * from lugaresturisticos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }

    public static function obtenerPorId($lugarid)
    {
        $sqlstr = "select * from lugaresturisticos where lugarid=:lugarid;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("lugarid"=>$lugarid)
        );
    }

    public static function nuevoLugar($lugar, $pais,$estado,$ciudad,$latitud,$longitud)
    {
        $sqlstr= "INSERT INTO lugaresturisticos (lugar, pais,estado,ciudad,latitud,longitud) values (:lugar, :pais,:estado,:ciudad,:latitud,:longitud);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugar"=>$lugar,
                "pais"=>$pais,
                "estado"=>$estado,
                "ciudad"=>$ciudad,
                "latitud"=>$latitud,
                "longitud"=>$longitud
            )
        );
    }

    public static function actualizarLugar($lugarid,$lugar, $pais,$estado,$ciudad,$latitud,$longitud)
    {
        $sqlstr = "UPDATE lugaresturisticos set lugar = :lugar, pais= :pais,estado = :estado,ciudad= :ciudad,latitud= :latitud,longitud= :longitud where lugarid=:lugarid";
        
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugarid"=>$lugarid,
                "lugar"=>$lugar,
                "pais"=>$pais,
                "estado"=>$estado,
                "ciudad"=>$ciudad,
                "latitud"=>$latitud,
                "longitud"=>$longitud
            )
        );
    }
    public static function eliminarLugar($lugarid)
    {
        $sqlstr = "DELETE FROM lugaresturisticos where lugarid=:lugarid;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugarid"=>$lugarid
            )
        );
    }


}
