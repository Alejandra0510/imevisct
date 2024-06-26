<?php
$identifierName = "DEV";
$proyId         = "_dev";

define('c_page_title', 'IMEVIS '.$identifierName);
define('c_num_reg', 10);
define('id_usr', 'cve_admin_cer'.$proyId);

//SESIONES ---
define('id_rol', 'tram_id_rol_cer'.$proyId );
define('id_direccion', 'tram_id_dir_cer'.$proyId );
define('id_area',      'tram_id_area_cer'.$proyId );
define('user',         'usuario_cer'.$proyId );
define('admin',        'tram_admin_cer'.$proyId );
define('rol',          'tram_rol_cer'.$proyId );
define('imp',          'tram_imp_cer'.$proyId );
define('edit',         'tram_edit_cer'.$proyId );
define('elim',         'tram_elim_cer'.$proyId );
define('nuev',         'tram_nuev_cer'.$proyId );
define('export',       'tram_exp_cer'.$proyId );
define('s_sexo',       'tram_sexo_cer'.$proyId );
define('s_img',        'tram_img_cer'.$proyId );
define('s_nombre',     'tram_nombre_cer'.$proyId );
define('s_ncompleto',  'tram_ncompleto_cer'.$proyId );
define('s_f_i',        'tram_fecha_ingreso_cer'.$proyId );
define('looked',       'tram_lock_session_cer'.$proyId );

//END SESIONES ---

//Sesiones extras ---
define('_editar_',     's_peditar_tram_cer'.$proyId );
define('_is_view_',    's_is_v_tram_cer'.$proyId );
define('_id_estatus_', 'id_estatus_cer'.$proyId );
