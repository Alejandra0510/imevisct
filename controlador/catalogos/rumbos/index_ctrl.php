<?php 

    class cat_rumbos {
        public function index() {
            require_once('business/catalogos/rumbos/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/rumbos/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/rumbos/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>