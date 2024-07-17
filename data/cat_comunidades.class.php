<?php
require_once $dir_fc."connections/conn_data.php";
//require_once $dir_fc."connections/conn_config.php";

class cComunidades extends BD
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


    private $id_comunidad;

    /**
     * Get the value of id_comunidad
     */ 
    public function getId_comunidad()
    {
        return $this->id_comunidad;
    }

    /**
     * Set the value of id_comunidad
     *
     * @return  self
     */ 
    public function setId_comunidad($id_comunidad)
    {
        $this->id_comunidad = $id_comunidad;

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

            if(isset($array_f["col"]) && $array_f["col"] != ""){
                $condition .= " AND c.colonia LIKE '%".$array_f["col"]."%' ";
            }

            if(isset($array_f["ast"]) && $array_f["ast"] != ""){
                $condition .= " AND c.id_tipo_asentamiento = ".$array_f["ast"]." ";
            }

            if(isset($array_f["sec"]) && $array_f["sec"] != ""){
                $condition .= " AND c.sectorint = ".$array_f["sec"]." ";
            }

        }

        $query = " SELECT c.id_comunidad,
                          c.id_tipo_asentamiento,
                          c.codigo,
                          c.colonia,
                          c.sectorint,
                          c.longitud,
                          c.latitud,
                          c.activo,
                          a.tipo_asentamiento
                     FROM cat_comunidad as c
                LEFT JOIN cat_tipo_asentamiento as a on a.id_tipo_asentamiento = c.id_tipo_asentamiento
                    WHERE 1 = 1
                      $condition
                 ORDER BY c.id_comunidad DESC " . $milimite;
                //  die($query);
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }


    public function getTAsentamiento(){
        $array_ta = array();
        try{
            $query = "SELECT id_tipo_asentamiento,
                             tipo_asentamiento
                        FROM cat_tipo_asentamiento
                       WHERE activo = 1";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_OBJ)){
                    $array_ta[$row->id_tipo_asentamiento] = $row->tipo_asentamiento;
                }
            }

            return $array_ta;
        }catch(\PDOException $e){
            return "Error: ".$e->getMessage();
        }
    }


    public function updateStatus($tipo){
        $correcto   = 1;        
        
        $update = " UPDATE cat_comunidad 
                       SET activo       = $tipo
                     WHERE id_comunidad = ".$this->getId_comunidad();

        $result = $this->conn->prepare($update);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;

    }


    public function deleteReg(){
        $correcto   = 2;
        
        $delete = "DELETE FROM cat_comunidad 
                         WHERE id_comunidad = ".$this->getId_comunidad();   

        $result = $this->conn->prepare($delete);
        $result->execute();
        $result = null;
        $this->conn = null;
        return $correcto;
    }



    public function closeOut(){
        $this->conn = null;
    } 

}
?>