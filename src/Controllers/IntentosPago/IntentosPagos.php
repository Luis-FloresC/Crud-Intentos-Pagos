<?php


namespace Controllers\IntentosPago;

use Controllers\PublicController;
use Views\Renderer;


/*
CREATE TABLE `nw202101`.`categorias` (
  `catid` BIGINT(8) NOT NULL AUTO_INCREMENT,
  `catnom` VARCHAR(45) NULL,
  `catest` CHAR(3) NULL DEFAULT 'ACT',
  PRIMARY KEY (`catid`));

*/

class IntentosPagos extends PublicController{

    public function run(): void{
        $viewData = arraY();
        $viewData["IntentosPagos"] = \Dao\IntentosPagos\IntentosPagos::obtenerTodos();
        Renderer::render('IntentosPago/IntentosPagos',$viewData);
    } 

}

?>