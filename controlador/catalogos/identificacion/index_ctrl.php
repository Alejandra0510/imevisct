<?php 

    class cat_identificaciones {
        public function index() {
            require_once('business/catalogos/identificacion/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/identificacion/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/identificacion/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>