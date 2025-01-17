<?php
require_once $dir_fc."connections/conn_data.php";
//require_once $dir_fc."connections/conn_config.php";

class cUsers extends BD
{
    private $id_usuario;
    private $id_rol;
    private $id_direccion;
    private $id_area;
    private $usuario;
    private $clave;
    private $nombre;
    private $apepa;
    private $apema;
    private $sexo;
    private $correo;
    private $fecha_ingreso;
    private $imprimir;
    private $editar;
    private $eliminar;
    private $nvo_usr;
    private $imagen;
    private $nvaclave;
    private $admin;
    private $nuevo;
    private $exportar;
    private $arraySearch;

    private $id_menu;

    private $filtro;
    private $inicio;
    private $fin;
    private $limite;

    private $conn;

    function __construct()
    {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }


    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */ 
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of id_rol
     */ 
    public function getId_rol()
    {
        return $this->id_rol;
    }

    /**
     * Set the value of id_rol
     *
     * @return  self
     */ 
    public function setId_rol($id_rol)
    {
        $this->id_rol = $id_rol;

        return $this;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of clave
     */ 
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set the value of clave
     *
     * @return  self
     */ 
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apepa
     */ 
    public function getApepa()
    {
        return $this->apepa;
    }

    /**
     * Set the value of apepa
     *
     * @return  self
     */ 
    public function setApepa($apepa)
    {
        $this->apepa = $apepa;

        return $this;
    }

    /**
     * Get the value of apema
     */ 
    public function getApema()
    {
        return $this->apema;
    }

    /**
     * Set the value of apema
     *
     * @return  self
     */ 
    public function setApema($apema)
    {
        $this->apema = $apema;

        return $this;
    }

    /**
     * Get the value of sexo
     */ 
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set the value of sexo
     *
     * @return  self
     */ 
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get the value of correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of fecha_ingreso
     */ 
    public function getFecha_ingreso()
    {
        return $this->fecha_ingreso;
    }

    /**
     * Set the value of fecha_ingreso
     *
     * @return  self
     */ 
    public function setFecha_ingreso($fecha_ingreso)
    {
        $this->fecha_ingreso = $fecha_ingreso;

        return $this;
    }

    /**
     * Get the value of imprimir
     */ 
    public function getImprimir()
    {
        return $this->imprimir;
    }

    /**
     * Set the value of imprimir
     *
     * @return  self
     */ 
    public function setImprimir($imprimir)
    {
        $this->imprimir = $imprimir;

        return $this;
    }

    /**
     * Get the value of editar
     */ 
    public function getEditar()
    {
        return $this->editar;
    }

    /**
     * Set the value of editar
     *
     * @return  self
     */ 
    public function setEditar($editar)
    {
        $this->editar = $editar;

        return $this;
    }

    /**
     * Get the value of eliminar
     */ 
    public function getEliminar()
    {
        return $this->eliminar;
    }

    /**
     * Set the value of eliminar
     *
     * @return  self
     */ 
    public function setEliminar($eliminar)
    {
        $this->eliminar = $eliminar;

        return $this;
    }

    /**
     * Get the value of nvo_usr
     */ 
    public function getNvo_usr()
    {
        return $this->nvo_usr;
    }

    /**
     * Set the value of nvo_usr
     *
     * @return  self
     */ 
    public function setNvo_usr($nvo_usr)
    {
        $this->nvo_usr = $nvo_usr;

        return $this;
    }

    /**
     * Get the value of imagen
     */ 
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get the value of nvaclave
     */ 
    public function getNvaclave()
    {
        return $this->nvaclave;
    }

    /**
     * Set the value of nvaclave
     *
     * @return  self
     */ 
    public function setNvaclave($nvaclave)
    {
        $this->nvaclave = $nvaclave;

        return $this;
    }

    /**
     * Get the value of admin
     */ 
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */ 
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get the value of nuevo
     */ 
    public function getNuevo()
    {
        return $this->nuevo;
    }

    /**
     * Set the value of nuevo
     *
     * @return  self
     */ 
    public function setNuevo($nuevo)
    {
        $this->nuevo = $nuevo;

        return $this;
    }

    /**
     * Get the value of exportar
     */ 
    public function getExportar()
    {
        return $this->exportar;
    }

    /**
     * Set the value of exportar
     *
     * @return  self
     */ 
    public function setExportar($exportar)
    {
        $this->exportar = $exportar;

        return $this;
    }

    /**
     * Get the value of filtro
     */ 
    public function getFiltro()
    {
        return $this->filtro;
    }

    /**
     * Set the value of filtro
     *
     * @return  self
     */ 
    public function setFiltro($filtro)
    {
        $this->filtro = $filtro;

        return $this;
    }

    /**
     * Get the value of inicio
     */ 
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set the value of inicio
     *
     * @return  self
     */ 
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get the value of fin
     */ 
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set the value of fin
     *
     * @return  self
     */ 
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get the value of limite
     */ 
    public function getLimite()
    {
        return $this->limite;
    }

    /**
     * Set the value of limite
     *
     * @return  self
     */ 
    public function setLimite($limite)
    {
        $this->limite = $limite;

        return $this;
    }

    /**
     * Get the value of id_menu
     */ 
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     * Set the value of id_menu
     *
     * @return  self
     */ 
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;

        return $this;
    }

    /**
     * Get the value of id_direccion
     */ 
    public function getId_direccion()
    {
        return $this->id_direccion;
    }

    /**
     * Set the value of id_direccion
     *
     * @return  self
     */ 
    public function setId_direccion($id_direccion)
    {
        $this->id_direccion = $id_direccion;

        return $this;
    }
    
    /**
     * Get the value of id_area
     */ 
    public function getId_area()
    {
        return $this->id_area;
    }

    /**
     * Set the value of id_area
     *
     * @return  self
     */ 
    public function setId_area($id_area)
    {
        $this->id_area = $id_area;

        return $this;
    }

    /**
     * Get the value of arraySearch
     */ 
    public function getArraySearch()
    {
        return $this->arraySearch;
    }

    /**
     * Set the value of arraySearch
     *
     * @return  self
     */ 
    public function setArraySearch($arraySearch)
    {
        $this->arraySearch = $arraySearch;

        return $this;
    }


    public function getUser() {

        $query = " SELECT U.id_usuario,
                          U.id_rol,
                          U.id_direccion,
                          U.id_area,
                          U.usuario,
                          U.nombre,
                          U.admin,
                          CONCAT_WS(' ', U.nombre, U.apepa, U.apema) AS nombrecompleto,
                          U.correo,
                          U.id_genero,
                          U.img,
                          DATE_FORMAT(U.fecha_ingreso, '%d/%m/%Y') AS fecha_ingreso,
                          U.imp,
                          U.edit,
                          U.elim,
                          U.new,
                          U.id_dir_ext,
                          R.rol
                     FROM ws_usuario AS U 
                LEFT JOIN ws_rol AS R ON R.id_rol = U.id_rol
                    WHERE usuario = '". $this->getUsuario()."' 
                      AND clave = '".$this->getClave()."' 
                      AND U.activo = 1
                    LIMIT 1";
                // die($query);
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;       
    }

    
    public function getAllReg( $rol ){
        //Inicio fin son para paginado
        $milimite    = "";
        $condition   = "";
        $cdt_master  = "";

        if ($this->getLimite() == 1){ $milimite = "LIMIT ".$this->getInicio().", ".$this->getFin();}
        $filtro = $this->getFiltro();

        if ($filtro != ""){

            $array_f = $this->getArraySearch();

            if(isset($array_f["idrs"]) && $array_f["idrs"] != ""){
                $condition .= " AND u.id_rol = ".$array_f["idrs"]." ";
            }

            if (isset($array_f["nams"]) && $array_f["nams"] != "") {
                $condition .= " AND CONCAT_WS(' ', u.nombre, u.apepa, u.apema) LIKE '%" . $array_f["nams"] . "%' ";
            }

            if (isset($array_f["usrs"]) && $array_f["usrs"] != "") {
                $condition .= " AND u.usuario LIKE '%" . $array_f["usrs"] . "%' ";
            }
        }

        if($rol > 1){
            $cdt_master = " AND id_usuario > 1 ";
        }

        $query  = " SELECT u.id_usuario, 
                           u.usuario, 
                           u.id_direccion, 
                           CONCAT_WS(' ', u.nombre, u.apepa, u.apema) AS nombre,
                           u.correo, 
                           u.activo, 
                           u.admin, 
                           u.id_area,
                           r.rol,
                           u.id_dir_ext
                      FROM ws_usuario as u
                 LEFT JOIN ws_rol as r on u.id_rol = r.id_rol
                     WHERE 1 = 1
                        $condition   
                        $cdt_master    
                    ORDER BY id_usuario DESC ".$milimite;
                    // die($query);
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }


    public function getRoles( $id_rol ){
        $array = array();
        $condition = "";

        if($id_rol > 1){
            $condition .= " AND id_rol > 1";
        }

        try{
            $query = "SELECT id_rol,
                             rol
                        FROM ws_rol
                       WHERE activo = 1
                       $condition";
                // die($query);

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_rol] = $row->rol;
                }
            }

            return $array;

        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function getDepExternas(){
        
        $array = array();

        try{
            $query = "SELECT id_dependencia,
                             prefijo,
                             direccion
                        FROM cat_dependencia_externa
                       WHERE activo = 1 ";
                    // die($query);
            
            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_dependencia] = '('.$row->prefijo.')'.' '.$row->direccion;
                }
            }
            return $array;

        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }

    public function getRegbyid(){

        $query = "  SELECT id_usuario, 
                           id_rol, 
                           id_direccion, 
                           id_area,
                           id_dir_ext,
                           usuario, 
                           id_genero, 
                           nombre, 
                           apepa, 
                           apema, 
                           correo,
                           imp, 
                           edit, 
                           elim, 
                           new, 
                           img, 
                           admin, 
                           activo
                      FROM ws_usuario
                    WHERE  id_usuario = ".$this->getId_usuario() ." LIMIT 1";
                // die($query);

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;

    }

    public function foundUserConcidencia(){
        //Busca si existe un usuario con el nombre
        $query = " SELECT usuario 
                     FROM ws_usuario 
                    WHERE usuario = '".$this->getUsuario()."' 
                      AND id_usuario = ".$this->getId_usuario();
        $result    = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function foundUser(){
        $query = "SELECT usuario 
                    FROM ws_usuario 
                   WHERE usuario = '".$this->getUsuario()."'";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }


    public function updateStatus($tipo){
        $correcto   = 1;        
        
        $update = " UPDATE ws_usuario 
                       SET activo     = $tipo
                     WHERE id_usuario = ".$this->getId_usuario();

        $result = $this->conn->prepare($update);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;

    }

    public function deleteReg(){
        $correcto   = 2;
        
        $delete = "DELETE FROM ws_usuario 
                         WHERE id_usuario = ".$this->getId_usuario();   

        $result = $this->conn->prepare($delete);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;
    }

    public function getRegbyPW(){
        $query  = " SELECT id_usuario, 
                           usuario 
                      FROM ws_usuario
                     WHERE id_usuario = ".$this->getId_usuario()." 
                      AND clave       = '".$this->getClave()."' LIMIT 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        $registrosf = $result->rowCount();
        return $registrosf;
    }

    public function updateRegPW(){
        
        $correcto   = 1;

        $exec = $this->conn->conexion();

        $update = " UPDATE ws_usuario
                       SET clave     = '".$this->getNvaclave()."'
                     WHERE id_usuario = ".$this->getId_usuario();
            // die($update);
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();

        $result = null;
        $exec = null;

        return $correcto;
    }

    public function getUserLock(){
        $query = "  SELECT id_usuario, 
                           id_rol, 
                           id_direccion, 
                           usuario, 
                           nombre,
                           CONCAT_WS(' ', nombre, apepa, apema) AS nombrecompleto,
                           correo,
                           sexo, 
                           img, 
                           DATE_FORMAT(fec_ingreso, '%d/%m/%Y' ) AS fecha_ingreso,
                           imp, 
                           edit, 
                           elim, 
                           nuev
                    FROM ws_usuario 
                    where id_usuario = ".$this->getId_usuario()." 
                      and clave = '".$this->getClave()."'
                      AND activo = 1";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    public function updateRegacount(){
        $correcto   = 1;
        $exec       = $this->conn->conexion();

        $update = " UPDATE ws_usuario
                       SET nombre     = '".$this->getNombre()."', 
                           apepa      = '".$this->getApepa()."',
                           apema      = '".$this->getApema()."',
                           usuario    = '" . $this->getUsuario() . "', 
                           correo     = '" . $this->getCorreo() . "',
                           sexo       = '" . $this->getSexo() . "'
                     WHERE id_usuario =  " . $this->getId_usuario()." ";
        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute();
        $exec->commit();
        return $correcto;
    }


    public function parentsMenu(){
     
        try{
            $query =" SELECT id, 
                             id_grupo,
                             texto, 
                             link  
                        FROM ws_menu 
                       WHERE id_grupo = 0 
                         AND activo = 1 
                    ORDER BY id ASC";
                    // echo $query;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\Exception $e){
            return "Error: ".$e->getMessage();
        }      
    }


    public function childsMenu($id_menu){

        try{
            $query = "  SELECT id, 
                               id_grupo, 
                               texto, 
                               link  
                          FROM ws_menu
                         WHERE id_grupo = $id_menu 
                           AND activo = 1
                      ORDER BY id ASC";
                    // echo $query;
            $result = $this->conn->prepare($query);
            $result->execute();
        return $result;

        }catch(\Exception $e){
            return "Error: ".$e->getMessage();
        }      
    }


    public function checarRol_menu( $id_menu ){
        try{
            $query ="   SELECT id_rol_menu, 
                               imp, 
                               edit, 
                               new, 
                               elim, 
                               export 
                          FROM ws_rol_menu 
                         WHERE id_menu = $id_menu
                           AND id_rol = ".$this->getId_rol()." ";
                        //    echo $query;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
        
    }


    public function checarUserMenu( $id_menu, $id_usr = null ){

        $condition = "";
        if($id_usr != ""){
            $condition .= " AND id_usuario = $id_usr ";
        }

        try{
            $query ="   SELECT id_usuario_menu, 
                               imp, 
                               edit, 
                               new, 
                               elim, 
                               export 
                          FROM ws_usuario_menu 
                         WHERE id_menu    = $id_menu
                           $condition ";
                        //    echo $query;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function checkDuplicateUsr( $user ){
        $total = 0;
        try{
            $query = "SELECT COUNT(id_usuario) as usuario
                        FROM ws_usuario
                       WHERE activo = 1
                         AND usuario = '$user' ";
                    // die($query);

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                $row = $result->fetch(PDO::FETCH_OBJ);
                $total = $row->usuario;
            }

            return $total;

        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function insertReg( $data ){
        $correcto = 1;
        $exec     = $this->conn->conexion();

        $insert = "INSERT INTO ws_usuario(id_direccion,
                                          id_area,
                                          id_rol,
                                          id_genero,
                                          id_usr_captura,
                                          fecha_ingreso,
                                          nombre,
                                          apepa,
                                          apema,
                                          usuario,
                                          clave,
                                          correo,
                                          img,
                                          id_dir_ext,
                                          imp,
                                          edit,
                                          new,
                                          elim,
                                          admin)
                                   VALUES(?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          NOW(),
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?,
                                          ?)";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute( $data );

        if($correcto == 1){
            $correcto = $exec->lastInsertId();
        }

        $exec->commit();
        return $correcto;
    }


    public function insertRegDtl( $data_dtl ){
        $correcto = 1;
        $exec     = $this->conn->conexion();

        $insert = "INSERT INTO ws_usuario_menu(id_usuario,
                                               id_menu,
                                               imp,
                                               edit,
                                               elim,
                                               new,
                                               export)
                                        VALUES(?,
                                               ?,
                                               ?,
                                               ?,
                                               ?,
                                               ?,
                                               ?)";

        $result = $this->conn->prepare($insert);
        $exec->beginTransaction();
        $result->execute( $data_dtl );

        if($correcto == 1){
            $correcto = $exec->lastInsertId();
        }

        $exec->commit();
        return $correcto;
    }


    public function updateReg( $data ){
        $correcto = 1;
        $exec     = $this->conn->conexion();

        $update = " UPDATE ws_usuario
                       SET id_direccion    = ?,
                           id_area         = ?,
                           id_rol          = ?,
                           id_genero       = ?,
                           id_usr_modifica = ?,
                           fecha_modifica  = NOW(),
                           nombre          = ?,
                           apepa           = ?,
                           apema           = ?,
                           correo          = ?,
                           admin           = ?,
                           img             = ?,
                           id_dir_ext      = ?
                     WHERE id_usuario      = ?";

        $result = $this->conn->prepare($update);
        $exec->beginTransaction();
        $result->execute( $data );
        $exec->commit();
        return $correcto;
    }


    public function deleteDtl( $id_user ){
        $correcto = 2;

        $delete = "DELETE FROM ws_usuario_menu 
                         WHERE id_usuario = $id_user";   

        $result = $this->conn->prepare($delete);
        $result->execute();
        return $correcto;
    }


    public function closeOut(){
        $this->conn = null;
    }  

}
?>