<?php 

    namespace Controllers\ORM;
    use Controllers\PublicController;
    use Views\Renderer;
    class Parameters extends PublicController{
        private $viewData = array();
        public function run():void{
          
            Renderer::render('ORM/parameters',$this->viewData);
        }
    }
?>