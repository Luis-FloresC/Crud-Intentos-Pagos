<?php
namespace Controllers\LugaresTuristicos;

use Controllers\PublicController;
use Views\Renderer;

class LugaresTuristico extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nuevo Lugar",
        "UPD" => "Editar Lugar de %s (%s)",
        "DSP" => "Detalle de Lugar de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
    private $_estOptions = array(
        "DIS"=> "Disponible",
        "NDS" => "No Disponible",
        "ERR" => "Error"
    );
    private $_viewData = array(
        "mode"=>"INS",
        "lugarid"=>0,
        "lugar"=>"",
        "pais"=>"",
        "estado"=>"DIS",
        "ciudad"=>"",
        "latitud"=>"",
        "longitud"=>"",
        "modeDsc"=>"",
        "readonly"=>false,
        "isInsert"=>false,
        "estOptions"=>[],
        "crsxToken" => ""
    );
    private function init(){
        if (isset($_GET["mode"])) {
            $this->_viewData["mode"] = $_GET["mode"];
            if($_GET["mode"] == "DSP")
            {
                $this->_viewData["readonly"] = true;
            }
            else
            {
                $this->_viewData["readonly"] = false;
            }
        }
        if (isset($_GET["lugarid"])) {
            $this->_viewData["lugarid"] = $_GET["lugarid"];
        }
        if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {
            error_log(
                $this->toString() . " Mode no valido " . $this->_viewData["mode"],
                0
            );
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=LugaresTuristicos_LugaresTuristicos',
                'Sucedio un error al procesar la página.'
            );
        }
        if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["lugarid"], 10) !== 0) {
            $this->_viewData["mode"] !== "DSP";
        }
    }
    private function handlePost()
    {

        

        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);

        if (!(isset($_SESSION["lugar_crsxToken"])
            && $_SESSION["lugar_crsxToken"] == $this->_viewData["crsxToken"])) {
            unset($_SESSION["lugar_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=LugaresTuristicos_LugaresTuristicos',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }
        $this->_viewData["lugarid"] = intval($this->_viewData["lugarid"], 10);

        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(DIS)|(NDI)|(ERR)$/"
        )
        ) {
            $this->_viewData["errors"][] = "Estado debe ser DIS,NDS o ERR";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\LugaresTuristicos\LugaresTuristicos::nuevoLugar(
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["estado"],
                    $this->_viewData["ciudad"],
                    $this->_viewData["latitud"],
                    $this->_viewData["longitud"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=LugaresTuristicos_LugaresTuristicos',
                        "¡Lugar guardado!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\LugaresTuristicos\LugaresTuristicos::actualizarLugar(
                    $this->_viewData["lugarid"],
                    $this->_viewData["lugar"],
                    $this->_viewData["pais"],
                    $this->_viewData["estado"],
                    $this->_viewData["ciudad"],
                   $this->_viewData["latitud"],
                   $this->_viewData["longitud"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=LugaresTuristicos_LugaresTuristicos',
                        "¡Lugar actualizado!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\LugaresTuristicos\LugaresTuristicos::eliminarLugar(
                    $this->_viewData["lugarid"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=LugaresTuristicos_LugaresTuristicos',
                        "¡Lugar eliminada!"
                    );
                }
                break;
            default:
                # code...
                break;
            }
        }
    }
    private function prepareViewData()
    {
        if ($this->_viewData["mode"] == "INS") {
             $this->_viewData["modeDsc"]
                 = $this->_modeStrings[$this->_viewData["mode"]];
        } else {
            $tmpLugars = \Dao\LugaresTuristicos\LugaresTuristicos::obtenerPorId(
                intval($this->_viewData["lugarid"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpLugars, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["lugarid"],
                $this->_viewData["lugar"],
                $this->_viewData["pais"],
                $this->_viewData["estado"],
                $this->_viewData["ciudad"],
                $this->_viewData["latitud"],
                $this->_viewData["longitud"]
            );
        }
        $this->_viewData["estOptions"]
            = \Utilities\ArrUtils::toOptionsArray(
                $this->_estOptions,
                'value',
                'text',
                'selected',
                $this->_viewData['estado']
            );

            $this->_viewData["crsxToken"] = md5(time() . "lugar");
            $_SESSION["lugar_crsxToken"] = $this->_viewData["crsxToken"];
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('LugaresTuristicos/LugaresTuristico', $this->_viewData);
    }
}

?>