<?php
session_start();
$dir_fc = "../";
/*-----------------------------------      Estableciendo la Clases  --------------------------------------*/
include_once $dir_fc.'data/tarea.class.php';
/*--------------------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/trop.php'; //Inclueye configuración de fecha y  hora de mexico
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'common/function.class.php';

$cAccion  = new cTarea();
$cFn      = new cFunction();

            if($autoasigna){
                //Asignando al técnico que le corresponda ..
                ##Autoasignación by JF! :)+

                $rs_tecdisp = $cAccion->getAllTecnicosDisponibles();
                $asinado    = false;    //Indicará si se asigna con el barrido de los técnicos
                $primero    = false;
                $primero_v  = 0;
                if($rs_tecdisp->num_rows > 0){
                    while($rw_disp = $rs_tecdisp->fetch_object()){
                        $id_r      = $rw_disp->id_usuario;

                        $cAccion->set_id_porasignar($id_r);

                        if(!$primero){
                            $primero_v   = $id_r;
                            $primero     = true;
                        }

                        $id_c      = $rw_disp->contador_servicios;
                        $id_ch     = $rw_disp->contador_servicios_h;
                        $aptop     = $cAccion->checa_habilidad();
                        if($aptop){
                            $asinado = true;
                            $cAccion->set_id_usuario_asignado($id_r);
                            break;
                        }
                    }
                    //Si no se asigno ninguno entonces se quedará el primero en la lista.
                    if(!$asinado){
                        $cAccion->set_id_usuario_asignado($primero_v);
                    }
                }
                else{
                    $rs_tec     = $cAccion->getAllTecnicos();
                    $asinado    = false;    //Indicará si se asigna con el barrido de los técnicos
                    $primero    = false;
                    $primero_v  = 0;

                    while($rw_tec = $rs_tec->fetch_object()){
                        $id_r      = $rw_tec->id_usuario;

                        $cAccion->set_id_porasignar($id_r);

                        if(!$primero){
                            $primero_v   = $id_r;
                            $primero     = true;
                        }

                        $id_c      = $rw_tec->contador_servicios;
                        $id_ch     = $rw_tec->contador_servicios_h;
                        $aptop     = $cAccion->checa_habilidad();
                        if($aptop){
                            $asinado = true;
                            $cAccion->set_id_usuario_asignado($id_r);
                            break;
                        }
                    }
                    //Si no se asigno ninguno entonces se quedará el primero en la lista.
                    if(!$asinado){
                        $cAccion->set_id_usuario_asignado($primero_v);
                    }
                }

                $cAccion->set_historia("Asignado por sistema");
                $cAccion->set_id_estatus(2);
                $ins_hist = $cAccion->updateRegbyAsig();
                $ins_hist = $cAccion->insertRegHist();
                $ins_hist = $cAccion->updateEnservicio(1);
            }else{
                $cAccion->set_historia("Enviado para autorizar.");
                $cAccion->set_id_estatus(7); //Estatus de autorizar
                $ins_hist = $cAccion->insertRegHist();
                $ins_hist = $cAccion->updateRegbyAutoriza();
            }


echo $inserted;
?>
