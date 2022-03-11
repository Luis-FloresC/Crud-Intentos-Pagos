<?php

namespace Controllers\Personas;

use Controllers\PublicController;
use Views\Renderer;

class Persona extends PublicController
{

    private $_modeStrings = array(
        "INS" => "Nuevo(a) Persona",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );

    private $_viewData = array(
        "mode" => "INS",
        "readonly" => false,
        "isInsert" => false,
        "modeDsc" => "",
        "id" => 0,
        "identidad" => "",
        "nombre" => "",
        "edad" => 0,
    );

    private function init()
    {

        if (isset($_GET["mode"])) {
            $this->_viewData["mode"] = $_GET["mode"];
            if ($_GET["mode"] == "DSP") {
                $this->_viewData["readonly"] = true;
            } else {
                $this->_viewData["readonly"] = false;
            }
        }

        if (isset($_GET["id"])) {
            $this->_viewData["id"] = $_GET["id"];
        }

        if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {
            error_log($this->toString() . " Mode no valido " . $this->_viewData["mode"], 0);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=Personas_Personas',
                'Sucedio un error al procesar la página.'
            );
        }


        if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["id"], 10) !== 0) {
            $this->_viewData["mode"] !== "DSP";
        }
    }

    private function handlePost()
    {

        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);

        if (!(isset($_SESSION["Persona_crsxToken"]) && $_SESSION["Persona_crsxToken"] == $this->_viewData["crsxToken"])) {
            unset($_SESSION["Persona_crsxToken"]);
            \Utilities\Site::redirectToWithMsg('index.php?page=Personas_Personas', 'Ocurrió un error, no se puede procesar el formulario.');
        }

        $this->_viewData["id"] = intval($this->_viewData["id"], 10);

       


        if (isset($this->_viewData["errors"]) ) {
        } else {

            switch ($this->_viewData["mode"]) {

                case "INS":
                    $result = \Dao\Personas\Personas::nuevoRegistro(
                        $this->_viewData["identidad"],
                        $this->_viewData["nombre"],
                        $this->_viewData["edad"]
                    );

                    if ($result) {
                        \Utilities\Site::redirectToWithMsg('index.php?page=Personas_Personas', '¡Registro guardado satisfactoriamente!');
                    }
                    break;

                case "UPD":
                    $result = \Dao\Personas\Personas::editarRegistro(
                        $this->_viewData["id"],
                        $this->_viewData["identidad"],
                        $this->_viewData["nombre"],
                        $this->_viewData["edad"]
                    );

                    if ($result) {
                        \Utilities\Site::redirectToWithMsg('index.php?page=Personas_Personas', '¡Registro actualizado satisfactoriamente!');
                    }
                    break;


                case "DEL":
                    $result = \Dao\Personas\Personas::eliminarRegistro($this->_viewData["id"]);

                    if ($result) {
                        \Utilities\Site::redirectToWithMsg('index.php?page=Personas_Personas', '¡Registro Eliminado satisfactoriamente!');
                    }
                    break;
            }
        }
    }

    private function prepareViewData()
    {

        if ($this->_viewData["mode"] == "INS") {
            $this->_viewData["modeDsc"] = $this->_modeStrings[$this->_viewData["mode"]];
        } //Fin del If
        else {

            $tmpPersona = \Dao\Personas\Personas::obtenerPorId(intval($this->_viewData["id"], 10));
            \Utilities\ArrUtils::mergeFullArrayTo($tmpPersona, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["id"],
                $this->_viewData["identidad"],
                $this->_viewData["nombre"],
                $this->_viewData["edad"],
            );
        } //Fin del else
        $this->_viewData["crsxToken"] = md5(time() . "Persona");
        $_SESSION["Persona_crsxToken"] = $this->_viewData["crsxToken"];
    } //Fin del prepareViewData

    public function run(): void
    {

        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        } //fin del if
        $this->prepareViewData();
        Renderer::render("Personas/Persona", $this->_viewData);
    } // fin del run()


}
