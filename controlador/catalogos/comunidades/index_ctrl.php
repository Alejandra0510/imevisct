<?php 

    class cat_comunidades {
        public function index() {
            require_once('business/catalogos/comunidades/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/comunidades/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/comunidades/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>