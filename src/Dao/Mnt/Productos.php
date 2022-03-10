<?php

namespace Dao\Mnt;

use Dao\Table;

class Productos extends Table
{


    public static function obtenerTodos()
    {
        $sqlstr = "select * from productos;";
        return self::obtenerRegistros($sqlstr, array());
    }


    public static function obtenerPorId($invPrdId)
    {
        $sqlstr = "select * from productos where invPrdId = :invPrdId;";
        return self::obtenerUnRegistro($sqlstr, array("invPrdId" => $invPrdId));
    }


    public static function nuevoRegistro($invPrdBrCod, $invPrdCodInt, $invPrdDsc, $invPrdTip, $invPrdEst, $invPrdPadre, $invPrdFactor, $invPrdVnd)
    {
        $sqlstr = "INSERT INTO productos (invPrdBrCod,invPrdCodInt,invPrdDsc,invPrdTip,invPrdEst,invPrdPadre,invPrdFactor,invPrdVnd) values (:invPrdBrCod,:invPrdCodInt,:invPrdDsc,:invPrdTip,:invPrdEst,:invPrdPadre,:invPrdFactor,:invPrdVnd);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "invPrdBrCod" => $invPrdBrCod,
                "invPrdCodInt" => $invPrdCodInt,
                "invPrdDsc" => $invPrdDsc,
                "invPrdTip" => $invPrdTip,
                "invPrdEst" => $invPrdEst,
                "invPrdPadre" => $invPrdPadre,
                "invPrdFactor" => $invPrdFactor,
                "invPrdVnd" => $invPrdVnd,
            )
        );
    }


    public static function editarRegistro($invPrdId, $invPrdBrCod, $invPrdCodInt, $invPrdDsc, $invPrdTip, $invPrdEst, $invPrdPadre, $invPrdFactor, $invPrdVnd)
    {
        $sqlstr = "UPDATE productos set invPrdBrCod = :invPrdBrCod,invPrdBrCod = :invPrdBrCod,invPrdCodInt = :invPrdCodInt,invPrdDsc = :invPrdDsc,invPrdTip = :invPrdTip,invPrdEst = :invPrdEst,invPrdPadre = :invPrdPadre,invPrdFactor = :invPrdFactor,invPrdVnd = :invPrdVnd where invPrdId = :invPrdId";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "invPrdId" => $invPrdId,
                "invPrdBrCod" => $invPrdBrCod,
                "invPrdCodInt" => $invPrdCodInt,
                "invPrdDsc" => $invPrdDsc,
                "invPrdTip" => $invPrdTip,
                "invPrdEst" => $invPrdEst,
                "invPrdPadre" => $invPrdPadre,
                "invPrdFactor" => $invPrdFactor,
                "invPrdVnd" => $invPrdVnd,
            )
        );
    }


    public static function eliminarRegistro($invPrdId)
    {
        $sqlstr = "DELETE FROM productos where invPrdId = :invPrdId;";
        return self::executeNonQuery($sqlstr, array("invPrdId" => $invPrdId));
    }
}
