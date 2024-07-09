<?php 

    class cat_calles {
        public function index() {
            require_once('business/catalogos/calles/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/calles/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/calles/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>
    