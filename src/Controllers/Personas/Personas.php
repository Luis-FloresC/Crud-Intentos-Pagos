<?php

namespace Controllers\Personas;

use Controllers\PublicController;
use Views\Renderer;


class Personas extends PublicController
{

    private $_viewData = array();

    public function run(): void
    {

        $this->_viewData["Personas"] = \Dao\Personas\Personas::obtenerTodos();
        Renderer::render("Personas/Personas", $this->_viewData);
    }
}
