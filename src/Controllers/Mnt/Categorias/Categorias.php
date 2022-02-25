<?php


namespace Controllers\Mnt\Categorias;

use Controllers\PublicController;
use Views\Renderer;


/*
CREATE TABLE `nw202101`.`categorias` (
  `catid` BIGINT(8) NOT NULL AUTO_INCREMENT,
  `catnom` VARCHAR(45) NULL,
  `catest` CHAR(3) NULL DEFAULT 'ACT',
  PRIMARY KEY (`catid`));

*/

class Categorias extends PublicController{

    public function run(): void{
        $viewData = arraY();
        $viewData["categorias"] = \Dao\Mnt\Categorias::ObtenerTodos();
        Renderer::render('mnt/Categorias',$viewData);
    } 

}

?>