<?php 

    class cat_ciudadanos {
        public function index() {
            require_once('business/catalogos/ciudadanos/index_vw.php');
        }
        public function ver() {
            require_once('business/catalogos/ciudadanos/editar_vw.php');
        }
        public function nuevo() {
            require_once('business/catalogos/ciudadanos/nuevo_vw.php');
        }
        public function error() {
        require_once('business/error.php');
        }
    }

?>
    