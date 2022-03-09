<?php 

    namespace Controllers\ORM;
    use Controllers\PublicController;
    use Views\Renderer;
    class Parameters extends PublicController{
        private $_viewData = array();
        public function run():void {
          
            if($this->isPostBack())
            {
                \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this->_viewData);
                $this->_viewData["tabla"] = \Dao\ORM\TableDescribe::obtenerEstructuradeTabla($this->_viewData["table"]);
                $this->GenerarControladorListado();
                $this->GenerarModeloTable();
               
            }
            Renderer::render('ORM/parameters',$this->_viewData);
        }

        private function GenerarControladorListado(){
            $buffer = array();
            $acum = "";
            $buffer[] = '<?php';
            $buffer[] = sprintf('namespace Controllers\%s;', $this->_viewData["namespace"]);
            $buffer[]=  'use Controllers\PublicController;';
            $buffer[] = 'use Views\Renderer;';
            $buffer[] = sprintf('class %s extends PublicController{', $this->_viewData["entity"]);
            $acum .= "("; 
            foreach ($this->_viewData["tabla"] as $field)
            {
                $buffer[] =sprintf(' private $_%s;', $field["Field"]);
                $acum .= "$".$field["Field"].",";

            }   
            $acum .= ")"; 
            $buffer[] = 'public function run(): void';
            $buffer[] = '{';   

            $buffer[] = '}';   
            $buffer[] = '}';    
            $buffer[] = '?>';
            $this->_viewData["acum"] = $acum;
            $this->_viewData["ListaControlador"] = htmlspecialchars(implode("\n", $buffer)); 
        }

        private function GenerarModeloTable()
        {
            $buffer = array();
            $buffer[] = '<?php';
            $buffer[] = sprintf('namespace Dao\%s;', $this->_viewData["namespace"]);
            $buffer[] = 'use Dao\Table;';
            $buffer[] = sprintf('class %s extends Table', $this->_viewData["entity"]);
            $buffer[] = '{';
            $buffer[] = 'public static function obtenerTodos()';
            $buffer[] = '{';
                $buffer[] = sprintf('$sqlstr = "select * from %s;";', $this->_viewData["table"]);
                $buffer[] = 'return self::obtenerRegistros(';
                $buffer[] = '$sqlstr,';
                $buffer[] = 'array()';
                $buffer[] = ');';
            $buffer[] ='}';    
            $buffer[] ='}';

            $buffer[] = '?>';

            $this->_viewData["ModeloTabla"] = htmlspecialchars(implode("\n", $buffer)); 
        }
    }
