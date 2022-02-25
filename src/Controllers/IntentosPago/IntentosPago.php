<?php
namespace Controllers\IntentosPago;

use Controllers\PublicController;
use Views\Renderer;

class IntentosPago extends PublicController
{
    private $_modeStrings = array(
        "INS" => "Nueva Pago",
        "UPD" => "Editar Pago de %s (%s)",
        "DSP" => "Detalle de Pago de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );
    private $_estOptions = array(
        "ENV"=> "Enviado",
        "PGD" => "Pagado",
        "CNL" => "Cancelado",
        "ERR" => "Error"
    );
    private $_viewData = array(
        "mode"=>"INS",
        "id"=>0,
        "clinete"=>"",
        "monto"=>"",
        "fecha_vencimiento"=>"",
        "estado"=>"ENV",
        "modeDsc"=>"",
        "readonly"=>false,
        "isInsert"=>false,
        "estOptions"=>[]
    );
    private function init(){
        if (isset($_GET["mode"])) {
            $this->_viewData["mode"] = $_GET["mode"];
        }
        if (isset($_GET["id"])) {
            $this->_viewData["id"] = $_GET["id"];
        }
        if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {
            error_log(
                $this->toString() . " Mode no valido " . $this->_viewData["mode"],
                0
            );
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=IntentosPago_IntentosPagos',
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
        $this->_viewData["id"] = intval($this->_viewData["id"], 10);
        if (!\Utilities\Validators::isMatch(
            $this->_viewData["estado"],
            "/^(ENV)|(PGD)|(CNL)|(ERR)$/"
        )
        ) {
            $this->_viewData["errors"][] = "Pago debe ser ENV,PGD,CNL o ERR";
        }

        if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0 ) {

        } else {
            switch ($this->_viewData["mode"]) {
            case 'INS':
                # code...
                $result = \Dao\IntentosPagos\IntentosPagos::nuevoPago(
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fecha_vencimiento"],
                    $this->_viewData["estado"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=IntentosPago_IntentosPagos',
                        "¡Pago guardado satisfactoriamente!"
                    );
                }
                break;
            case 'UPD':
                $result = \Dao\IntentosPagos\IntentosPagos::actualizarPago(
                    $this->_viewData["id"],
                    $this->_viewData["cliente"],
                    $this->_viewData["monto"],
                    $this->_viewData["fecha_vencimiento"],
                    $this->_viewData["estado"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=IntentosPago_IntentosPagos',
                        "¡Pago actualizado satisfactoriamente!"
                    );
                }
                break;
            case 'DEL':
                $result = \Dao\IntentosPagos\IntentosPagos::eliminarPago(
                    $this->_viewData["id"]
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        'index.php?page=IntentosPago_IntentosPagos',
                        "¡Pago eliminada satisfactoriamente!"
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
            $tmpPagos = \Dao\IntentosPagos\IntentosPagos::obtenerPorId(
                intval($this->_viewData["id"], 10)
            );
            \Utilities\ArrUtils::mergeFullArrayTo($tmpPagos, $this->_viewData);
            $this->_viewData["modeDsc"] = sprintf(
                $this->_modeStrings[$this->_viewData["mode"]],
                $this->_viewData["cliente"],
                $this->_viewData["id"],
                $this->_viewData["monto"],
                $this->_viewData["fecha_vencimiento"],
                $this->_viewData["estado"]
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
    }
    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->prepareViewData();
        Renderer::render('IntentosPago/IntentosPago', $this->_viewData);
    }
}

?>