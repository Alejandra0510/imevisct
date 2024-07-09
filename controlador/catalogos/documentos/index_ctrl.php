<?php 

    class cat_documentos {
        public function index() {
            require_once('business/catalogos/documentos/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/documentos/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/documentos/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>