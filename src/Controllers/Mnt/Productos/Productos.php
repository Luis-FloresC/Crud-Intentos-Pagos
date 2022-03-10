<?php
namespace Controllers\Mnt\Productos;
use Controllers\PublicController;
use Views\Renderer;


class Productos extends PublicController{
 private $_invPrdId;
 private $_invPrdBrCod;
 private $_invPrdCodInt;
 private $_invPrdDsc;
 private $_invPrdTip;
 private $_invPrdEst;
 private $_invPrdPadre;
 private $_invPrdFactor;
 private $_invPrdVnd;
private $_viewData = array();

public function run(): void
{

$this->_viewData["productos"] = \Dao\Mnt\Productos::obtenerTodos();
Renderer::render("Mnt/Productos",$this->_viewData);

}


}
?>