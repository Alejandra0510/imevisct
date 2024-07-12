<?php
require_once $dir_fc."connections/conn_data.php";
//require_once $dir_fc."connections/conn_config.php";

class cCiudadanos extends BD
{
    private $conn;

    function __construct()
    {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }

    private $filtro;
    private $inicio;
    private $fin;
    private $limite;

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


    private $arraySearch;

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


    public function getAllReg(){
        $milimite = "";
        $condition = "";

        if ($this->getLimite() == 1) {
            $milimite = " LIMIT " . $this->getInicio() . ", " . $this->getFin();
        }

        if ($this->getFiltro() != "") {

            $array_f = $this->getArraySearch();

            if(isset($array_f["ciu_b"]) && $array_f["ciu_b"] != ""){
                $condition .= " AND CONCAT_WS(' ', c.nombre, c.apepat, c.apemat ) LIKE '%".$array_f["ciu_b"]."%' ";
            }

            if(isset($array_f["col_b"]) && $array_f["col_b"] != ""){
                $condition .= " AND c.id_colonia = ".$array_f["col_b"]." ";
            }

            if(isset($array_f["mun_b"]) && $array_f["mun_b"] != ""){
                $condition .= " AND c.id_municipio = ".$array_f["mun_b"]." ";
            }

            if(isset($array_f["ctt_b"]) && $array_f["ctt_b"] != ""){
                $condition .= " AND c.id_tipo_contacto = ".$array_f["ctt_b"]." ";
            }

            if(isset($array_f["tcd_b"]) && $array_f["tcd_b"] != ""){
                $condition .= " AND c.id_tipo_ciudadano = ".$array_f["tcd_b"]." ";
            }
        }

        $query = " SELECT c.id_ciudadano, 
                          c.id_colonia,
                          c.id_calle,
                          c.id_municipio,
                          CONCAT_WS(' ', c.nombre, c.apepat, c.apemat ) as nombre_completo,
                          c.numero_exterior,
                          c.numero_interior,
                          c.cp,
                          c.telefono_fijo,
                          c.telefono_cel,
                          c.activo,
                          a.colonia,
                          e.calle
                     FROM cat_ciudadano as c
                LEFT JOIN cat_comunidad as a on c.id_colonia = a.id_comunidad
                LEFT JOIN cat_calles as e on c.id_calle = e.id_calle
                    WHERE 1 = 1
                      $condition
                 ORDER BY c.id_ciudadano DESC " . $milimite;
                //  die($query);
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }


    public function getComunidades(){
        $array = array();

        try{

            $query = "SELECT id_comunidad,
                             colonia
                        FROM cat_comunidad
                       WHERE activo = 1 
                    ORDER BY colonia ASC";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_comunidad] = $row->colonia;
                }
            }
            return $array;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }

    public function getMunicipios(){
        $array = array();

        try{
            $query = "SELECT id_municipio,
                             municipio
                        FROM cat_municipios
                       WHERE activo = 1 
                         AND id_municipio = 105
                    ORDER BY municipio ASC";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_municipio] = $row->municipio;
                }
            }
            return $array;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function getTCiudadanos(){
        $array = array();

        try{
            $query = "SELECT id_tipo_ciudadano,
                             tipo_ciudadano
                        FROM cat_tipo_ciudadano
                       WHERE activo = 1 ";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_tipo_ciudadano] = $row->tipo_ciudadano;
                }
            }
            return $array;

        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function getTContacto(){
        $array = array();

        try{
            $query = "SELECT id_tipo_contacto,
                             tipo_contacto
                        FROM cat_tipo_contacto
                       WHERE activo = 1 ";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_tipo_contacto] = $row->tipo_contacto;
                }
            }
            return $array;

        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function getCallesById( $id_colonia ){
        $array = array();

        try{
            $query = "SELECT id_calle,
                             calle
                        FROM cat_calles
                       WHERE id_comunidad = $id_colonia";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array[$row->id_calle] = $row->calle;
                }
            }

            return $array;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }

    public function getCpById( $id_col ){
        $cp = "";

        try {
            $query = "SELECT codigo
                        FROM cat_comunidad
                       WHERE id_comunidad = $id_col";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                $row = $result->fetch(PDO::FETCH_OBJ);
                $cp = $row->codigo;
            }
            return $cp;
        } catch (\Throwable $th) {
            return "Error: ".$th->getMessage();
        }
    }


    public function insertReg( $data ){
        $correcto = 1;
        $exec     = $this->conn->conexion();

        $insert = "INSERT INTO cat_ciudadano(id_tipo_ciudadano,
                                             id_tipo_contacto,
                                             id_municipio,
                                             id_colonia,
                                             id_calle,
                                             id_entre_calle,
                                             id_entre_calle2,
                                             id_usuario_captura,
                                             fecha_captura,
                                             nombre,
                                             apepa,
                                             apemat,
                                             numero_exterior,
                                             numero_interior,
                                             cp,
                                             telefono_fijo,
                                             telefono_cel,
                                             email)
                                      VALUES(?,
                                             ?,
                                             ?,
                                             ?,
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

    public function closeOut(){
        $this->conn = null;
    }  


}
?>