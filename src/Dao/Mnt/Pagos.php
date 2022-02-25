<?php
namespace Dao\Mnt;




use Dao\Table;

class Pagos extends Table
{
    public static function obtenerTodos()
    {
        $sqlstr = "select * from intentospagos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }
    public static function obtenerPorId($id)
    {
        $sqlstr = "select * from intentospagos where id=:id;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("id"=>$id)
        );
    }

    public static function nuevoPago($cliente, $monto,$fecha_vencimiento,$estado)
    {
        $sqlstr= "INSERT INTO intentospagos (cliente, monto,fecha_vencimiento,estado) values (:cliente,:monto,:fecha_vencimiento,:estado);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "cliente"=>$cliente,
                "monto"=>$monto,
                "fecha_vencimiento"=>$fecha_vencimiento,
                "estado"=>$estado
            )
        );
    }

    public static function actualizarPago($id,$cliente, $monto,$fecha_vencimiento,$estado)
    {
        $sqlstr = "UPDATE intentospagos set cliente=:cliente, monto=:monto,fecha_vencimiento=:fecha_vencimiento,estado = :estado where id=:id";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "cliente"=>$cliente,
                "monto"=>$monto,
                "fecha_vencimiento"=>$fecha_vencimiento,
                "estado"=>$estado,
                "id"=>$id
            )
        );
    }
    public static function eliminarCategoria($id)
    {
        $sqlstr = "DELETE FROM intentospagos where id=:id;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "id"=>$id
            )
        );
    }
}


?>