<!-- BEGIN HEADER-->
<header id="header">
    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="<?php echo $raiz?>">
                            <img src="dist/assets/img/logo.png">
                        </a>
                        <a href="<?php echo $raiz?>business/" class="margin-logo-op">
                        </a>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right">
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <img src="<?php echo $raiz?>dist/assets/img/<?php echo $_SESSION[s_img]?>" class="round"/>
                        <span class="profile-info">
                            <?php echo $_SESSION[s_nombre]?>
                            <small><?php echo $_SESSION[rol].' '.$_SESSION[s_aplicativo]?></small>
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li class="dropdown-header">Configuración</li>
                        <li><a href="<?php echo $raiz?>?controller=sys&action=account">Mi cuenta</a></li>
                        <li class="divider"></li>
                        <!-- <li><a href="<?php echo $raiz?>business/sys/lockscreen.php"><i class="fa fa-fw fa-lock"></i> Bloquear</a></li> -->
                        <li><a href="<?php echo $raiz?>business/sys/logout.php"><i class="fa fa-fw fa-power-off text-danger"></i> Salir del sistema</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
