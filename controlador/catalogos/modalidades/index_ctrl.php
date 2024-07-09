<?php 

    class cat_modalidades {
        public function index() {
            require_once('business/catalogos/modalidades/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/modalidades/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/modalidades/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>