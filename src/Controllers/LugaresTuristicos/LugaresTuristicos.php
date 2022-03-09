<?php

namespace Controllers\LugaresTuristicos;

use Controllers\PublicController;
use Views\Renderer;

class LugaresTuristicos extends PublicController{

    public function run(): void{
        $viewData = array();
        
        $viewData["LugaresTuristicos"] = \Dao\LugaresTuristicos\LugaresTuristicos::obtenerTodos();

        Renderer::render('LugaresTuristicos/LugaresTuristicos',$viewData);
    } 

}

?>