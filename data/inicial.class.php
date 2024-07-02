<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";
/**
 * * Operaciones y movimientos que se realizan para el menú y otras herramientas de inicio que viene de la base de datos
 */
class cInicial extends BD
{
    private $conn;

    function __construct()
    {
        $this->conn = new BD();
    }

    public function menuParents($usr){
        try {
            $query = " SELECT DISTINCT (um.id_menu), 
                              m.texto, 
                              m.link, 
                              m.title, 
                              m.class
		 			     FROM ws_usuario_menu as um
		 			     JOIN ws_menu m ON um.id_menu = m.id
		 			    WHERE m.id_grupo = 0 
                          AND um.id_usuario = $usr 
                          AND m.activo = 1  
                     ORDER BY m.orden ASC ";
                    // die($query);

            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }
        catch(\PDOException $e)
        {
            return "Error!: " . $e->getMessage();
        }
    }

    public function menuChild($parent, $usr){
        try {
            $query = " SELECT m.id, 
                              m.texto, 
                              m.link, 
                              m.title, 
                              m.class,
                              m.accesskey,
                              m.class
                         FROM ws_menu m
                        WHERE m.id_grupo > 0 
                          AND m.activo = 1 
                          AND m.id_grupo = $parent
                          AND m.id IN (SELECT id_menu 
                                         FROM ws_usuario_menu 
                                        WHERE id_usuario = ".$usr." )
                       ORDER BY orden ASC ";
                //    die($query);
                    
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }
        catch(\PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function traeRolByUser($id){
        $query = " SELECT id_usuario_menu as id_rol  
                     FROM ws_usuario_menu 
                    WHERE id_usuario = $id";
                // die($query);

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function checarRol_pagina($id_usr, $id_menu) {

        $query  = " SELECT COUNT(id_usuario_menu) as contador, 
                           imp, 
                           edit, 
                           elim, 
                           new,
                           export
                      FROM ws_usuario_menu
                     WHERE id_usuario = $id_usr 
                       AND id_menu = $id_menu 
                     LIMIT 1";
                // echo $query;

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

}
?>
