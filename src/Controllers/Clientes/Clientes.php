<?php 

namespace Controllers\Clientes;

use Controllers\PublicController;
use Views\Renderer;
class Clientes extends PublicController
{
    public function run(): void{
        $viewData = array();
        $viewData["titulo"] = "Manejo de Clientes";
        $viewData["categorias"] = \Dao\Mnt\Categorias::ObtenerTodos();
        $viewData["clientes"] = array(
            "Luis",
            "Juan",
            "Edgar",
            "Flor"
        );
        Renderer::render('Clientes/Clientes',$viewData);
    }

  
}




?>