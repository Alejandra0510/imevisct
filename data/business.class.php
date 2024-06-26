<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";

class cBusiness extends BD
{
    private $conn;

    function __construct() {
        //Esta es la que llama a la base de datos
        //parent::__construct();
        $this->conn = new BD();
    }


    public function getArrayColonias(){
        $arraycol = array();
        try{
            $query = "SELECT id_comunidad, colonia
                        FROM cat_comunidad
                       WHERE activo = 1";

            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($rowc = $result->fetch(PDO::FETCH_OBJ)){
                    $arraycol[$rowc->id_comunidad] = $rowc->colonia;
                }
            }
            return $arraycol;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }
   


    public function getOrigenData($fecha_i, $fecha_f, $aplicativo, $direccion, $area, $colonia,  $rol_usr, $area_usr = null){
        $cond = "";
        $join = "";

        if($direccion > 0){
            // $cond .= " AND dtl.id_direccion_asig = ".$direccion." AND dtl.estatus_rechazado = 0 ";
            $join = "LEFT JOIN tbl_reporte_dtl as d on d.id_reporte = r.id_reporte";
            $cond .= " AND d.id_direccion_asig = $direccion AND d.estatus_rechazado = 0" ;
        }

        $cond .= ($colonia > 0) ? " AND r.id_colonia = $colonia )" : "";
        $cond .= ($rol_usr == 5 && $area_usr != "") ? " AND d.id_area_asig = ".$area_usr : '';
        $cond .= (isset($area) && $area != null && $area > 0) ? " AND d.id_area_asig = ".$area : '';


        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $cond .= " AND r.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $cond .= " AND r.id_origen IN (1,2,4,5,16,18)";
            }
        }

        try{
            $query = "SELECT COUNT(r.id_reporte) as value, 
                             o.origen as name
                        FROM tbl_reporte as r
                   LEFT JOIN cat_origen as o on r.id_origen = o.id_origen AND o.activo = 1
                        $join
                       WHERE 1 = 1  
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                       $cond
                    GROUP BY r.id_origen
                    ORDER BY value DESC";
                    // die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }

    }


    public function getColoniasInfo($dependencia, $fecha_i, $fecha_f, $rol_usr, $area_usr = null, $area, $aplicativo){
        $cond = "";

        if($dependencia > 0){
            $cond .= " AND dtl.id_direccion_asig = ".$dependencia." AND dtl.estatus_rechazado = 0 ";
        }

        if($area > 0 && $area != "" && isset($area)){
            
            $cond .= " AND dtl.id_area_asig = ".$area;
        }

        if($rol_usr == 5){
            if($area_usr != ""){
                $cond .= " AND dtl.id_area_asig = ".$area_usr;
            }
        }

        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $cond .= " AND r.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $cond .= " AND r.id_origen IN (1,2,4,5,16,18)";
            }
        }

        try{
            $query = "SELECT COUNT(r.id_reporte) as total, 
                             r.id_colonia, 
                             o.colonia
                        FROM tbl_reporte as r
                  INNER JOIN tbl_reporte_dtl as dtl on r.id_reporte = dtl.id_reporte
                   LEFT JOIN cat_comunidad as o on r.id_colonia = o.id_comunidad AND o.activo = 1
                  INNER JOIN cat_origen as ori on r.id_origen = ori.id_origen
                       WHERE r.id_colonia is not null 
                         AND ori.activo = 1 $cond
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                         AND dtl.observador = 0
                    GROUP BY r.id_colonia
                    ORDER BY total DESC
                       LIMIT 15 ";
                    //    die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }

    }


    public function getTramitesServ($dependencia, $colonia,  $fecha_i, $fecha_f, $rol_usr, $area_usr = null, $area, $aplicativo){
        $cond = "";
        
        $cond .= ($dependencia > 0) ? " AND r.id_direccion_asig = ".$dependencia. " AND r.estatus_rechazado = 0" : '';

        $cond .= ($colonia > 0) ? " AND r.id_reporte IN(SELECT b.id_reporte FROM tbl_reporte as b WHERE b.id_colonia = $colonia )" : "";
        
        $cond .= ($rol_usr == 5 && $area_usr != "") ? " AND r.id_area_asig = ".$area_usr : '';

        $cond .= (isset($area) && $area != null && $area > 0) ? " AND r.id_area_asig = ".$area : '';

        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $cond .= " AND rm.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $cond .= " AND rm.id_origen IN (1,2,4,5,16,18)";
            }
        }

        try{
            $query = "SELECT COUNT(r.id_reporte) as value, 
                             t.nombre as name
                        FROM tbl_reporte_dtl as r
                  INNER JOIN tbl_reporte as rm on rm.id_reporte = r.id_reporte
                  INNER JOIN cat_origen as ori on ori.id_origen = rm.id_origen
                   LEFT JOIN cat_remtys as t on r.id_remty = t.id_remtys AND t.activo = 1
                       WHERE r.id_remty is not null 
                         AND ori.activo = 1 $cond
                         AND rm.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                         AND r.observador = 0
                       GROUP BY t.id_remtys
                       ORDER BY value DESC
                       LIMIT 20";
                    //    die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }

    }

    public function getArrayEstatus(){
        try{
            $query = "SELECT id_estatus, estatus
                        FROM cat_estatus
                       WHERE activo = 1";
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }


    public function getDataEstatus($iddireccion, $idestatus, $fecha_i, $fecha_f, $aplicativo){

        $condition = "";

        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $condition .= " AND r.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $condition .= " AND r.id_origen IN (1,2,4,5,16,18)";
            }
        }

        try{
            $query = "SELECT COUNT(r.id_reporte) as total 
                        FROM tbl_reporte as r
                   LEFT JOIN cat_origen as o on r.id_origen = o.id_origen
                  INNER JOIN tbl_reporte_dtl as d on r.id_reporte = d.id_reporte
                       WHERE d.id_direccion_asig = $iddireccion 
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f' 
                         AND r.id_estatus = $idestatus
                         $condition
                         AND o.activo = 1
                         AND d.estatus_rechazado = 0
                         AND d.observador = 0
                       LIMIT 1 ";
                    //    die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }


    public function getTotalDirecciones($id_direccion){
        $arrayDirecciones = array();
        try{
            $query = "SELECT dtl.id_direccion_asig
                        FROM tbl_reporte_dtl as dtl
                       INNER JOIN tbl_reporte as r on r.id_reporte = dtl.id_reporte
                        LEFT JOIN cat_origen as o on r.id_origen = o.id_origen
                       WHERE dtl.id_direccion_asig = $id_direccion
                         AND dtl.estatus_rechazado = 0
                         AND o.activo = 1
                         AND dtl.observador = 0";
                        //  die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($rowd = $result->fetch(PDO::FETCH_OBJ)){
                    array_push($arrayDirecciones, $rowd->id_direccion_asig);
                }
            }
            return $arrayDirecciones;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }

    public function getTotalEstDir($id_direccion, $fecha_i, $fecha_f, $rol_usr, $area_usr = null, $area, $aplicativo){

        $condition = "";

        if($rol_usr == 5){
            if($area_usr != ""){
                $condition .= " AND dtl.id_area_asig = $area_usr ";
            }
        }

        if(isset($area) && $area != null && $area > 0){

            $condition .= " AND dtl.id_area_asig = $area ";
        }

        
        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $condition .= " AND r.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $condition .= " AND r.id_origen IN (1,2,4,5,16,18)";
            }
        }


        try{
            $query = "SELECT COUNT(dtl.id_reporte) as value, 
                             est.estatus as name
                        FROM tbl_reporte_dtl as dtl
                  INNER JOIN tbl_reporte as r on r.id_reporte = dtl.id_reporte
                  INNER JOIN cat_origen as ori on ori.id_origen = r.id_origen
                   LEFT JOIN cat_estatus as est on dtl.id_estatus = est.id_estatus
                       WHERE dtl.id_direccion_asig = $id_direccion
                         AND est.activo = 1
                         AND ori.activo = 1
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                         AND dtl.observador = 0
                         $condition
                    GROUP BY dtl.id_estatus
                    ORDER BY value DESC ";
                    //    die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }


    public function getArraySectoresCol(){
        $arraySectores = array();
        try{
            $query = "SELECT sectorint
                        FROM cat_comunidad 
                    GROUP BY sectorint 
                    ORDER BY sectorint ASC";
                    // die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($rowd = $result->fetch(PDO::FETCH_OBJ)){
                    // array_push($arraySectores, $rowd->sectorint);
                    $arraySectores[$rowd->sectorint] = 'Sector '.$rowd->sectorint;
                }
            }
            return $arraySectores;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }

  
    public function getDataEstatusS($id_estatus, $sector, $dependencia, $fecha_i, $fecha_f, $rol_usr, $area_usr = null, $area, $aplicativo){
        $cond = "";    
        $cond_area = "";
        $condition = "";

        if($dependencia > 0){
            
            if($rol_usr == 5){
                if($area_usr != null){
                    $cond_area .= " AND dtl.id_area_asig = $area_usr ";
                }
            }

            if($area != null && $area > 0){

                $cond_area .= " AND dtl.id_area_asig = $area ";
            }

            $cond .= " AND r.id_reporte IN (SELECT dtl.id_reporte
                                             FROM tbl_reporte_dtl as dtl
                                            WHERE dtl.id_direccion_asig = ".$dependencia. "
                                              AND dtl.estatus_rechazado = 0
                                              AND dtl.observador = 0
                                              $cond_area ) ";
        }


        if($aplicativo != ""){
            if($aplicativo == 2 ){
                $condition .= " AND r.id_origen IN (1,2,4,5,6,16,18)";
            }else if($aplicativo == 1){
                $condition .= " AND r.id_origen IN (1,2,4,5,16,18)";
            }
        }

        

        try{
            $query = "SELECT COUNT(r.id_reporte) as total
                        FROM tbl_reporte as r
                   LEFT JOIN cat_comunidad as c on r.id_colonia = c.id_comunidad 
                   LEFT JOIN cat_origen as o on r.id_origen = o.id_origen 
                       WHERE r.id_estatus = $id_estatus 
                         AND c.sectorint = $sector
                         AND o.activo = 1
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                        $cond
                       LIMIT 1 ";
                        // die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }



    public function getArrayAplicativos( $aplicativo ){
        $arraya    = array();
        $condition = "";

        if($aplicativo == 1){
            $condition = " AND id_aplicativo = $aplicativo";
        }

        try{
            $query = "SELECT id_aplicativo,
                             descripcion
                        FROM cat_aplicativo 
                       WHERE activo = 1
                       $condition";
                    // die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            if($result->rowCount() > 0){
                while($rowa = $result->fetch(PDO::FETCH_OBJ)){
                    // array_push($arraySectores, $rowd->sectorint);
                    $arraya[$rowa->id_aplicativo] = $rowa->descripcion;
                }
            }
            return $arraya;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }



    public function getDataEstatusA($id_estatus, $dependencia, $fecha_i, $fecha_f, $rol_usr, $area_usr = null, $id_a){
        $cond = "";    
        $cond_area = "";

        if($dependencia > 0){
            
            if($rol_usr == 5){
                if($area_usr != null){
                    $cond_area = " AND dtl.id_area_asig = $area_usr ";
                }
            }

            $cond .= " AND r.id_reporte IN (SELECT dtl.id_reporte
                                             FROM tbl_reporte_dtl as dtl
                                            WHERE dtl.id_direccion_asig = ".$dependencia. "
                                              AND dtl.estatus_rechazado = 0
                                              AND dtl.observador = 0
                                              $cond_area ) ";
        }

        try{
            $query = "SELECT COUNT(r.id_reporte) as total
                        FROM tbl_reporte as r
                   LEFT JOIN cat_origen as o on r.id_origen = o.id_origen 
                   LEFT JOIN cat_aplicativo as a on r.id_aplicativo = a.id_aplicativo
                       WHERE r.id_estatus = $id_estatus 
                         AND r.id_aplicativo = $id_a
                         AND o.activo = 1
                         AND r.fecha_captura BETWEEN '$fecha_i' AND '$fecha_f'
                        $cond
                       LIMIT 1 ";
                        // die($query);
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result;
        }catch(\PDOException $e){
            return "Error! : ".$e->getMessage();
        }
    }


    public function closeOut(){
        $this->conn = null;
    }
  

}
