<?php
require_once $dir_fc."connections/conn_data.php";
//require_once $dir_fc."connections/conn_config.php";

class cCalles extends BD
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


    public function getAllReg(){
        $milimite = "";
        $condition = "";

        if ($this->getLimite() == 1) {
            $milimite = " LIMIT " . $this->getInicio() . ", " . $this->getFin();
        }

        if ($this->getFiltro() != "") {
        //    $array_f = $this->getArraySearch();

        //     if(isset($array_f["rolb"]) && $array_f["rolb"] != ""){
        //         $condition .= " AND rol LIKE '%".$array_f["rolb"]."%' ";
        //     }

        //     if(isset($array_f["desb"]) && $array_f["desb"] != ""){
        //         $condition .= " AND descripcion LIKE '%".$array_f["desb"]."%' ";
            // }
        }

        $query = " SELECT c.id_calle,
                          c.id_comunidad,
                          c.calle,
                          c.descripcion,
                          c.activo,
                          CONCAT_WS(' ', t.abreviatura, m.colonia ) as colonia
                     FROM cat_calles as c
                LEFT JOIN cat_comunidad as m on c.id_comunidad = m.id_comunidad
                LEFT JOIN cat_tipo_asentamiento as t on m.id_tipo_asentamiento = t.id_tipo_asentamiento
                    WHERE 1 = 1
                      $condition
                 ORDER BY c.id_comunidad ASC, c.id_calle DESC " . $milimite;
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
                       WHERE activo = 1 ";

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
    public function getVialidades(){
        $array = array();

        try{

            $query = "SELECT 
                        FROM 
                       WHERE activo = 1 ";

            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }

    public function closeOut(){
        $this->conn = null;
    }  



}
?>