<?php

namespace Controllers\ORM;

use Controllers\PublicController;
use Views\Renderer;

class Parameters extends PublicController
{
    private $_viewData = array();
    public function run(): void
    {

        if ($this->isPostBack()) {
            \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);
            $this->_viewData["tabla"] = \Dao\ORM\TableDescribe::obtenerEstructuradeTabla($this->_viewData["table"]);
            $this->GenerarControladorListado();
            $this->GenerarModeloTable();
            $this->GeneradorControladorTabla();
            $this->GenerarVistaDeRegistros();
            $this->GenerarFormularioTabla();
        }
        Renderer::render('ORM/parameters', $this->_viewData);
    }

    private function GenerarControladorListado()
    {
        $buffer = array();
        $TiposDatos = array();
        $acum = "";
        $buffer[] = '<?php';
        $buffer[] = sprintf('namespace Controllers\%s;', $this->_viewData["namespace"]);
        $buffer[] =  'use Controllers\PublicController;';
        $buffer[] = 'use Views\Renderer;';
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = sprintf('class %s extends PublicController{', $this->_viewData["entity"]);
        $acum .= "(";
        foreach ($this->_viewData["tabla"] as $field) {
            $buffer[] = sprintf(' private $_%s;', $field["Field"]);
            $acum .= "$" . $field["Field"] . ",";

            $TiposDatos[] = $field["Type"];
        }
        $acum .= ")";
        $buffer[] = 'private $_viewData = array();';
        $buffer[] = '';
        $buffer[] = 'public function run(): void';
        $buffer[] = '{';
        $buffer[] = '';
        $buffer[] = sprintf('$this->_viewData["%s"] = \Dao\%s\%s::obtenerTodos();', $this->_viewData["table"], $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = sprintf('Renderer::render("%s/%s",$this->_viewData);', $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = '';
        $buffer[] = '}';

        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = '}';
        $buffer[] = '?>';
        $this->_viewData["acum"] = $acum;
        $this->_viewData["TiposDatos"] = htmlspecialchars(implode("\n", $TiposDatos));
        $this->_viewData["ListaControlador"] = htmlspecialchars(implode("\n", $buffer));
    }

    private function GenerarModeloTable()
    {
        $buffer = array();
        $buferrArreglos = array();
        $bufferGuardar = array();
        $bufferArrViewDataG = array();
        $bufferArrViewDataM = array();
        $llavePrimaria = "";
        $ParametrosConLLavePrimaria = "(";

        $ParametrosGuardar = "(";
        $ParametrosModificar = "";
        $Parametros = "(";
        $bandera = false;

        $buffer[] = '<?php';
        $buffer[] = sprintf('namespace Dao\%s\%s;', $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = 'use Dao\Table;';
        $buffer[] = sprintf('class %s extends Table', $this->_viewData["entity"]);
        $buffer[] = '{';
        $buffer[] = '';
        $buffer[] = '';
        //Método de Obtener todos los registros
        $buffer[] = 'public static function obtenerTodos()';
        $buffer[] = '{';
        $buffer[] = sprintf('$sqlstr = "select * from %s;";', $this->_viewData["table"]);
        $buffer[] = 'return self::obtenerRegistros($sqlstr,array());';
        $buffer[] = '}';
        //Fin del método de Obtener todos los registros

        //Arreglo para los campos
        foreach ($this->_viewData["tabla"] as $field) {

            if ($field["Key"] == "PRI" && $bandera == false) {
                $llavePrimaria = $field["Field"];
                $bufferArrViewDataM[] = sprintf('$this->_viewData["%s"]', $field["Field"]);
                $ParametrosConLLavePrimaria .= "$" . $field["Field"];
                $buferrArreglos[] =  '"' . $field["Field"] . '"' . "=>" . "$" . $field["Field"] . ',';
                $bandera = true;
            } else {
                if ($bandera) {
                    $bufferGuardar[] =  '"' . $field["Field"] . '"' . "=>" . "$" . $field["Field"] . ',';
                    $Parametros .= "$" . $field["Field"];
                    $bufferArrViewDataG[] = sprintf('$this->_viewData["%s"]', $field["Field"]);
                    $ParametrosModificar .= $field["Field"] . ' = :' . $field["Field"];
                    $bandera = false;
                } else {
                    $bufferArrViewDataG[] = sprintf(',$this->_viewData["%s"]', $field["Field"]);
                    $bufferGuardar[] =  '"' . $field["Field"] . '"' . "=>" . "$" . $field["Field"] . ',';
                    $Parametros .= "#$" . $field["Field"];
                }
                $bufferArrViewDataM[] = sprintf(',$this->_viewData["%s"]', $field["Field"]);
                $ParametrosModificar .= '#' . $field["Field"] . ' = :' . $field["Field"];
                $ParametrosConLLavePrimaria .= "#$" . $field["Field"];
                $buferrArreglos[] =  '"' . $field["Field"] . '"' . "=>" . "$" . $field["Field"] . ',';
            }
        }
        //Fin de Arreglos para los campos
        $ParametrosConLLavePrimaria .= ")";
        $Parametros .= ")";


        $ParametrosGuardar = str_replace("#", ",", $Parametros);
        $this->_viewData["ArrayM"] = (implode("\n", $buferrArreglos));
        $this->_viewData["ArrayG"] = (implode("\n", $bufferGuardar));
        $this->_viewData["ArrayM2"] = (implode("\n", $bufferArrViewDataM));
        $this->_viewData["ArrayG2"] = (implode("\n", $bufferArrViewDataG));
        $buffer[] = '';
        $buffer[] = '';
        //Método de Obtener un registros
        $buffer[] = sprintf('public static function obtenerPorId($%s)', $llavePrimaria);
        $buffer[] = '{';
        $buffer[] = sprintf('$sqlstr = "select * from %s where %s = :%s;";', $this->_viewData["table"], $llavePrimaria, $llavePrimaria);
        $buffer[] = sprintf('return self::obtenerUnRegistro($sqlstr,array("%s"=>$%s));', $llavePrimaria, $llavePrimaria);
        $buffer[] = '}';
        //Fin método de Obtener un registros
        $buffer[] = '';
        $buffer[] = '';
        //Método para guardar tatos
        $buffer[] = sprintf('public static function nuevoRegistro%s',  $ParametrosGuardar);
        $buffer[] = '{';
        $buffer[] = sprintf('$sqlstr = "INSERT INTO %s %s values %s;";', $this->_viewData["table"], str_replace("$", "", $ParametrosGuardar), str_replace("$", ":", $ParametrosGuardar));
        $buffer[] = 'return self::executeNonQuery(';
        $buffer[] = '$sqlstr,';
        $buffer[] = 'array';
        $buffer[] = '(';
        $buffer[] = sprintf('%s', $this->_viewData["ArrayG"]);
        $buffer[] = '));';
        $buffer[] = '}';
        //Fin método para guardar tatos
        $buffer[] = '';
        $buffer[] = '';
        //Método para Editar datos
        $buffer[] = sprintf('public static function editarRegistro%s',  str_replace("#", ",", $ParametrosConLLavePrimaria));
        $buffer[] = '{';
        $buffer[] = sprintf('$sqlstr = "UPDATE %s set %s where %s = :%s";', $this->_viewData["table"], str_replace("#", ",", $ParametrosModificar), $llavePrimaria, $llavePrimaria);
        $buffer[] = 'return self::executeNonQuery(';
        $buffer[] = '$sqlstr,';
        $buffer[] = 'array';
        $buffer[] = '(';
        $buffer[] = sprintf('%s', $this->_viewData["ArrayM"]);
        $buffer[] = '));';
        $buffer[] = '}';
        //Fin método para guardar tatos
        $buffer[] = '';
        $buffer[] = '';
        //Método de eliminar un registros
        $buffer[] = sprintf('public static function eliminarRegistro($%s)', $llavePrimaria);
        $buffer[] = '{';
        $buffer[] = sprintf('$sqlstr = "DELETE FROM %s where %s = :%s;";', $this->_viewData["table"], $llavePrimaria, $llavePrimaria);
        $buffer[] = sprintf('return self::executeNonQuery($sqlstr,array("%s"=>$%s));', $llavePrimaria, $llavePrimaria);
        $buffer[] = '}';
        //Fin método de eliminar un registros
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = '}';
        $buffer[] = '?>';

        $this->_viewData["ParametrosConLLavePrimaria"] = str_replace("#", ",", $ParametrosConLLavePrimaria);
        $this->_viewData["Parametros"] = str_replace("#", ",", $Parametros);
        $this->_viewData["Parametros3"] = str_replace("$", ":", $ParametrosGuardar);
        $this->_viewData["Parametros2"] = $ParametrosModificar;
        $this->_viewData["ModeloTabla"] = htmlspecialchars(implode("\n", $buffer));
        $this->_viewData["LlavePrimaria"] = $llavePrimaria;
    }


    private function GeneradorControladorTabla()
    {
        $buffer = array();

        $bufferVariables = array();
        $bufferVariables[] = '"mode"=>"INS",';
        $bufferVariables[] = '"readonly"=>false,';
        $bufferVariables[] = '"isInsert"=>false,';
        $bufferVariables[] = '"modeDsc"=>"",';
        $bufferCampos = array();
        foreach ($this->_viewData["tabla"] as $field) {
            if ($field["Type"] == "bigint" || $field["Type"] == "int") {
                $bufferVariables[] = '"' . $field["Field"] . '"=>' . '0,';
            } else {
                $bufferVariables[] = '"' . $field["Field"] . '"=>' . '"",';
            }
            $bufferCampos[] =  sprintf('$this->_viewData["%s"],', $field["Field"]);
        }



        $buffer[] = '<?php';
        $buffer[] = '';
        $buffer[] = sprintf('namespace Controllers\%s\%s;', $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = 'use Controllers\PublicController;';
        $buffer[] = 'use Views\Renderer;';
        $buffer[] = '';
        $buffer[] = sprintf('class %s extends PublicController{', $this->_viewData["table"]);
        $buffer[] = '';
        //Modos string
        $buffer[] = 'private $_modeStrings = array(';
        $buffer[] = sprintf('   "INS" => "Nuevo(a) %s",', $this->_viewData["entity"]);
        $buffer[] = '   "UPD" => "Editar %s (%s)",';
        $buffer[] = '   "DSP" => "Detalle de %s (%s)",';
        $buffer[] = '   "DEL" => "Eliminando %s (%s)"';
        $buffer[] = ');';
        // fin de modo string
        $buffer[] = '';
        $buffer[] = 'private $_viewData = array(';
        $buffer[] = sprintf('%s', implode("\n", $bufferVariables));
        $buffer[] = ');';
        $buffer[] = '';
        $buffer[] = 'private function init(){';
        $buffer[] = '';
        $buffer[] =  'if (isset($_GET["mode"])) {';
        $buffer[] =  '  $this->_viewData["mode"] = $_GET["mode"];';

        $buffer[] =  '  if($_GET["mode"] == "DSP")';
        $buffer[] =  '  {';
        $buffer[] =  '      $this->_viewData["readonly"] = true;';
        $buffer[] =  '  }';
        $buffer[] =  '  else';
        $buffer[] =  '  {';
        $buffer[] =  '    $this->_viewData["readonly"] = false;';
        $buffer[] =  '  }';
        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = sprintf(' if (isset($_GET["%s"])) {', $this->_viewData["LlavePrimaria"]);
        $buffer[] = sprintf('   $this->_viewData["%s"] = $_GET["%s"];', $this->_viewData["LlavePrimaria"], $this->_viewData["LlavePrimaria"]);
        $buffer[] = ' }';
        $buffer[] = '';
        $buffer[] = 'if (!isset($this->_modeStrings[$this->_viewData["mode"]])) {';
        $buffer[] = 'error_log($this->toString() . " Mode no valido " . $this->_viewData["mode"],0);';
        $buffer[] = '\Utilities\Site::redirectToWithMsg(';
        $buffer[] = sprintf("'index.php?page=%s_%s',", $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = " 'Sucedio un error al procesar la página.'";
        $buffer[] = ' );';
        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = ' if ($this->_viewData["mode"] !== "INS" && intval($this->_viewData["id"], 10) !== 0) {';
        $buffer[] = '  $this->_viewData["mode"] !== "DSP";';
        $buffer[] = ' }';
        $buffer[] = '';
        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = 'private function handlePost(){';
        $buffer[] = '';
        $buffer[] = '\Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);';
        $buffer[] = '';
        $buffer[] = sprintf('if(!(isset($_SESSION["%s_crsxToken"]) && $_SESSION["%s_crsxToken"] == $this->_viewData["crsxToken"])) ', $this->_viewData["entity"], $this->_viewData["entity"]);
        $buffer[] = '{';
        $buffer[] = sprintf('   unset($_SESSION["%s_crsxToken"]);', $this->_viewData["entity"]);
        $buffer[] = sprintf("   \Utilities\Site::redirectToWithMsg('index.php?page=%s_%s','Ocurrió un error, no se puede procesar el formulario.');", $this->_viewData["namespace"], $this->_viewData["entity"]);


        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = sprintf('$this->_viewData["%s"] = intval($this->_viewData["%s"], 10);', $this->_viewData["LlavePrimaria"], $this->_viewData["LlavePrimaria"]);
        $buffer[] = '';
        $buffer[] = 'if (!\Utilities\Validators::isMatch($this->_viewData["estado"],"/^(ENV)|(PGD)|(CNL)|(ERR)$/")) {';
        $buffer[] = ' $this->_viewData["errors"][] = "Pago debe ser ENV,PGD,CNL o ERR";';
        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = 'if (isset($this->_viewData["errors"]) && count($this->_viewData["errors"]) > 0) { }';
        $buffer[] = 'else {';
        $buffer[] = '';
        $buffer[] = 'switch ($this->_viewData["mode"]) {';
        $buffer[] = '';
        $buffer[] = 'case "INS":';
        $buffer[] = sprintf('$result = \Dao\%s\%s::nuevoRegistro(%s);', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["ArrayG2"]);
        $buffer[] = '';
        $buffer[] = 'if ($result) {';
        $buffer[] = sprintf("   \Utilities\Site::redirectToWithMsg('index.php?page=%s_%s','¡Registro guardado satisfactoriamente!');", $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = '}';
        $buffer[] = '   break;';
        $buffer[] = '';
        $buffer[] = 'case "UPD":';
        $buffer[] = sprintf('$result = \Dao\%s\%s::editarRegistro(%s);', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["ArrayM2"]);
        $buffer[] = '';
        $buffer[] = 'if ($result) {';
        $buffer[] = sprintf("   \Utilities\Site::redirectToWithMsg('index.php?page=%s_%s','¡Registro actualizado satisfactoriamente!');", $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = '}';
        $buffer[] = '   break;';
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = 'case "DEL":';
        $buffer[] = sprintf('$result = \Dao\%s\%s::eliminarRegistro($this->_viewData["%s"]);', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["LlavePrimaria"]);
        $buffer[] = '';
        $buffer[] = 'if ($result) {';
        $buffer[] = sprintf("   \Utilities\Site::redirectToWithMsg('index.php?page=%s_%s','¡Registro Eliminado satisfactoriamente!');", $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = '}';
        $buffer[] = '   break;';
        $buffer[] = '';

        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = '}';
        $buffer[] = '';

        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = 'private function prepareViewData(){';
        $buffer[] = '';
        $buffer[] = ' if ($this->_viewData["mode"] == "INS") {';
        $buffer[] = '       $this->_viewData["modeDsc"] = $this->_modeStrings[$this->_viewData["mode"]];';
        $buffer[] = '} //Fin del If';
        $buffer[] = 'else {';
        $buffer[] = '';
        $buffer[] = sprintf('$tmp%s = \Dao\%s\%s::obtenerPorId(intval($this->_viewData["%s"], 10));', $this->_viewData["entity"], $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["LlavePrimaria"]);
        $buffer[] = sprintf('\Utilities\ArrUtils::mergeFullArrayTo($tmp%s, $this->_viewData);', $this->_viewData["entity"]);
        $buffer[] = sprintf('$this->_viewData["modeDsc"] = sprintf($this->_modeStrings[$this->_viewData["mode"]],%s);', implode("\n", $bufferCampos));
        $buffer[] = '';
        $buffer[] = '} //Fin del else';
        $buffer[] = sprintf('$this->_viewData["crsxToken"] = md5(time() . "%s");', $this->_viewData["entity"]);
        $buffer[] = sprintf('$_SESSION["%s_crsxToken"] = $this->_viewData["crsxToken"];', $this->_viewData["entity"]);
        $buffer[] = '';
        $buffer[] = '} //Fin del prepareViewData';
        $buffer[] = '';
        $buffer[] = 'public function run(): void';
        $buffer[] = '{';
        $buffer[] = '';
        $buffer[] = ' $this->init();';
        $buffer[] = 'if ($this->isPostBack()) {';
        $buffer[] = '   $this->handlePost();';
        $buffer[] = '} //fin del if';
        $buffer[] = ' $this->prepareViewData();';
        $buffer[] = sprintf('Renderer::render("%s/%s", $this->_viewData);', $this->_viewData["namespace"], $this->_viewData["entity"]);
        $buffer[] = '';
        $buffer[] = '} // fin del run()';
        $buffer[] = '';
        $buffer[] = '';
        $buffer[] = '}';
        $buffer[] = '';
        $buffer[] = '?>';
        $this->_viewData["ControladorTabla"] = htmlspecialchars(implode("\n", $buffer));
        $this->_viewData["V2"] = htmlspecialchars(implode("\n", $bufferVariables));
    }

    private function GenerarVistaDeRegistros()
    {
        $buffer = array();
        $buffer[] = '<div class="page-header">';
        $buffer[] = sprintf('<h1 class="all-tittles">Lista de %s &nbsp;&nbsp;<small><button type="button" name="btnNuevo" id="btnNuevo" class="btn btn-success btn-sm">Nuevo registro</button></small></h1>', $this->_viewData["entity"]);
        $buffer[] = '</div>';
        $buffer[] = '';
        $buffer[] = '<table class="table table-dark table-striped table-bordered">';
        $buffer[] = '<thead>';
        $buffer[] = '<tr>';
        foreach ($this->_viewData["tabla"] as $field) {
            $buffer[] = sprintf('   <th>%s</th>', $field["Field"]);
        }
        $buffer[] = '</thead>';
        $buffer[] = '</tr>';
        $buffer[] = '<tbody>';
        $buffer[] = sprintf('{{foreach %s}}', $this->_viewData["table"]);
        $buffer[] = '<tr>';
        foreach ($this->_viewData["tabla"] as $field) {
            $buffer[] = sprintf('   <td>{{%s}}</td>', $field["Field"]);
        }
        $buffer[] = '</tr>';
        $buffer[] = sprintf('{{endfor %s}}', $this->_viewData["table"]);
        $buffer[] = '</tbody>';
        $buffer[] = '</table>';
        $buffer[] =  '<script> ';
        $buffer[] = ' document.addEventListener("DOMContentLoaded", (e) => { ';
        $buffer[] =   '  var btnNuevo = document.getElementById("btnNuevo"); ';
        $buffer[] =  '  btnNuevo.addEventListener("click", (e) => { ';
        $buffer[] =     '  e.preventDefault(); ';
        $buffer[] =     '  e.stopPropagation(); ';
        $buffer[] =     '  window.location.assign( ';
        $buffer[] =   sprintf('     "index.php?page=%s_%s&mode=INS&%s=0"', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["LlavePrimaria"]);
        $buffer[] =      '   ); ';
        $buffer[] =   '  }); ';
        $buffer[] = ' }); ';
        $buffer[] = '</script> ';
        $buffer[] = '';
        $this->_viewData["FormListar"] = htmlspecialchars(implode("\n", $buffer));
    }

    public function GenerarFormularioTabla()
    {
        $buffer = array();
        $buffer[] = '<div class="container-fluid">';
        $buffer[] = '  <div class="form">';

        $buffer[] = '   <figure class="text-center">';
        $buffer[] = '       <blockquote class="blockquote">';
        $buffer[] = sprintf('          <h1>Formulario de %s</h1>', $this->_viewData["entity"]);
        $buffer[] = '       </blockquote>';
        $buffer[] = '       <figcaption class="blockquote-footer">';
        $buffer[] = '           Descripción: <cite title="Source Title">{{modeDsc}}</cite>';
        $buffer[] = '       </figcaption>';
        $buffer[] = '   </figure> ';
        $buffer[] = '   <div class="form-row">  ';
        $buffer[] = sprintf('           <form action="index.php?page=%s.%s&mode={{mode}}&%s={{id}}" class="needs-validation" novalidate method="post">', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["LlavePrimaria"]);
        $buffer[] = '';
        $buffer[] = '               <input type="hidden" name="crsxToken" value="{{crsxToken}}" />';
        foreach ($this->_viewData["tabla"] as $field) {
            $buffer[] = '             <div class="col-md-4 mb-3">';
            $buffer[] = sprintf('               <label for="%s">%s</label>', $field["Field"], $field["Field"]);
            if ($field['Null'] == "NO") {
                $buffer[] = sprintf('               <input type="text" class="form-control" name="%s" id="%s" placeholder="%s" value="{{%s}}" required  />', $field["Field"], $field["Field"], $field["Field"], $field["Field"]);
            } else {
                $buffer[] = sprintf('               <input type="text" class="form-control" name="%s" id="%s" placeholder="%s" value="{{%s}}"  />', $field["Field"], $field["Field"], $field["Field"], $field["Field"]);
            }
            $buffer[] = '               <div class="valid-feedback">¡Se ve bien!</div>';
            $buffer[] = '               <div class="invalid-feedback">Por favor ingrese los datos correctos!</div>';
            $buffer[] = '             </div>';
            $buffer[] = '';
        }
        $buffer[] = '       {{ifnot readonly}}';
        $buffer[] = '';
        $buffer[] = '           <button class="btn btn-primary" type="submit">Enviar</button> &nbsp;';
        $buffer[] = '           <button name="btnCancelar" id="btnCancelar" class="btn btn-danger">Cancelar</button>';
        $buffer[] = '';
        $buffer[] = '       {{endifnot readonly}}';
        $buffer[] = '';
        $buffer[] = '       {{if readonly}}';
        $buffer[] = '';
        $buffer[] = '           <button name="btnCancelar" id="btnCancelar" class="btn btn-success">Ver Lista de Pagos</button>';
        $buffer[] = '';
        $buffer[] = '       {{endif readonly}}';
        $buffer[] = '';
        $buffer[] = '           </form>';
        $buffer[] = '   </div>';

        $buffer[] = '  </div>';
        $buffer[] = '</div>';
        $buffer[] = '';
        $buffer[] =  '<script> ';
        $buffer[] = '';
        $buffer[] = ' document.addEventListener("DOMContentLoaded", (e) => { ';
        $buffer[] =   '  var btnNuevo = document.getElementById("btnCancelar"); ';
        $buffer[] =  '  btnNuevo.addEventListener("click", (e) => { ';
        $buffer[] =     '  e.preventDefault(); ';
        $buffer[] =     '  e.stopPropagation(); ';
        $buffer[] =     '  window.location.assign( ';
        $buffer[] =   sprintf('     "index.php?page=%s_%s"', $this->_viewData["namespace"], $this->_viewData["entity"], $this->_viewData["LlavePrimaria"]);
        $buffer[] =      '   ); ';
        $buffer[] =   '  }); ';
        $buffer[] = ' }); ';
        $buffer[] = '';
        $buffer[] = '</script> ';

        $buffer[] = '';
        $buffer[] =  '<script> ';
        $buffer[] = '';

        $buffer[] = ' (function () {';
        $buffer[] = '   "use strict";';
        $buffer[] = '  window.addEventListener(';
        $buffer[] = '     "load",';
        $buffer[] = '    function () {';
        $buffer[] = '      var forms = document.getElementsByClassName("needs-validation");';
        $buffer[] = '     var validation = Array.prototype.filter.call(';
        $buffer[] = '    forms,';
        $buffer[] = '    function (form) { ';
        $buffer[] = '       form.addEventListener( ';
        $buffer[] = '          "submit", ';
        $buffer[] = '          function (event) { ';
        $buffer[] = '            if (form.checkValidity() === false) { ';
        $buffer[] = '               event.preventDefault(); ';
        $buffer[] = '               event.stopPropagation(); ';
        $buffer[] = '           }';
        $buffer[] = '           form.classList.add("was-validated");';
        $buffer[] = '       },';
        $buffer[] = '       false';
        $buffer[] = '   );';
        $buffer[] = '   }';
        $buffer[] = '  );';
        $buffer[] = '  },';
        $buffer[] = '  false';
        $buffer[] = '  );';
        $buffer[] = '  })();';
        $buffer[] = '';
        $buffer[] = '</script> ';
        $this->_viewData["FormTabla"] = htmlspecialchars(implode("\n", $buffer));
    }
}
