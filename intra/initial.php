<?php session_start();?>
<?php
   require_once"../lib/conexionl.php";
   require_once"../lib/funcionl.php";
   if(isset($_GET['salir'])):
      login::salir();
   endif;
   if(isset($_SESSION['dentro'])):
?>
<!DOCTYPE html>
<html>
  <head>
    <title>GMZBol</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.css">
    <link rel="stylesheet" href="../public/css/skins/_all-skins.min.css">
    <link rel="shortcut icon" href="../public/img/icon.png">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script> 
      function outlinex(){ document.out.submit() } 
   </script>
  </head>
  <body ng-app="gmzbol" class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="javascript:;" class="logo">
          <span class="logo-mini"><b>GMZ</b></span>
          <span class="logo-lg"><b>GMZ</b>Bol</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button" >
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- <li class="dropdown notifications-menu">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="glyphicon glyphicon-bell"></i>
                  <span class="label label-warning">1</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Notificaciones</li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="javascript:;"><i class="glyphicon glyphicon-user text-red"></i> Manual de usuario</a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer">&nbsp;</li>
                </ul>
              </li> -->
              <li class="dropdown user user-menu">
                <a href="javascript:;">
                  <!-- <img src="../public/img/user.jpg" class="user-image" alt="Avatar"> -->
                  <span class="hidden-xs"><?php echo $_SESSION['uname']; ?></span>
                </a>
              </li>
              <li class="dropdown user user-menu">
                <a href="javascript:outlinex();" class="bg-red"><i class="glyphicon glyphicon-off"></i>Salir</a>
                <form name="out" class="form-log" method="GET">
                  <input type="hidden" name="salir" > 
                </form>
              </li>
              <li>
                <a href="javascript:;" data-toggle="control-sidebar"><i class="glyphicon glyphicon-cog"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">NAVIGACIÓN</li>
            <li class="active treeview">
              <a ui-sref="in">
                <i class="glyphicon glyphicon-dashboard"></i> <span>Inicio</span> <i class="glyphicon glyphicon-angle-left pull-right"></i>
              </a>
            </li>
            <li class="treeview">
              <a href="javascript:;">
                <i class="glyphicon glyphicon-shopping-cart"></i>
                <span>Productos</span>
                <i class="glyphicon glyphicon-menu-right pull-right" style="font-size: 8px"></i>
              </a>
              <ul class="treeview-menu">
                <li><a ui-sref="rp"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar producto</a></li>
                <li><a ui-sref="lp"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar productos</a></li>
                <li><a ui-sref="rv"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar proveedor</a></li>
                <li><a ui-sref="lv"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar proveedores</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="javascript:;">
                <i class="glyphicon glyphicon-tasks"></i>
                <span>Servicios</span>
                <i class="glyphicon glyphicon-menu-right pull-right" style="font-size: 8px"></i>
              </a>
              <ul class="treeview-menu">
                <li><a ui-sref="rs"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar servicio</a></li>
                <li><a ui-sref="ls"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar servicios</a></li>
                <li><a ui-sref="rc"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar categoria</a></li>
                <li><a ui-sref="lc"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar categorias</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="javascript:;">
                <i class="glyphicon glyphicon-user"></i>
                <span>Clientes</span>
                <i class="glyphicon glyphicon-menu-right pull-right" style="font-size: 8px"></i>
              </a>
              <ul class="treeview-menu">
                <li><a ui-sref="rl"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar cliente</a></li>
                <li><a ui-sref="ll"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar clientes</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="javascript:;">
                <i class="glyphicon glyphicon-asterisk"></i>
                <span>Configuración</span>
                <i class="glyphicon glyphicon-menu-right pull-right" style="font-size: 8px"></i>
              </a>
              <ul class="treeview-menu">
                <li><a ui-sref="uc"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar unidad</a></li>
                <li><a ui-sref="ec"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Datos de la empresa</a></li>
                <li><a ui-sref="sc"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Números de serie</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="javascript:;">
                <i class="glyphicon glyphicon-user"></i>
                <span>Usuarios</span>
                <i class="glyphicon glyphicon-menu-right pull-right" style="font-size: 8px"></i>
              </a>
              <ul class="treeview-menu">
                <li><a ui-sref="ru"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Registrar usuario</a></li>
                <li><a ui-sref="lu"><i class="glyphicon glyphicon-triangle-right text-sm"></i>Listar usuarios</a></li>
              </ul>
            </li>
          </ul>
        </section>
      </aside>
      <div class="content-wrapper">
        <section class="content-header">
          <h1><i>Panel de navegación</i></h1>
          <ol class="breadcrumb">
            <li><a href="javascript:;"><i class="glyphicon glyphicon-dashboard"></i> <span ng-model="pnav">Inicio</span></a></li>
          </ol>
        </section>
        <div id="rate-editor-container"></div>
        <section class="content">
          <div id="main" ui-view="vmain" autoscroll="false" class="anim-in-out anim-zoom-out-full"
            data-anim-sync="true"
            data-anim-speed="400"
            ng-style="{
              '-webkit-transition-duration': 400 + 'ms',
              '-moz-transition-duration': 400 + 'ms',
              '-ms-transition-duration': 400 + 'ms',
              '-o-transition-duration': 400 + 'ms',
              'transition-duration': 400 + 'ms'
            }"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          </div>
        </section>
      </div>
      <aside class="control-sidebar control-sidebar-dark">
        <div class="tab-content">
          <div class="tab-pane" id="control-sidebar-home-tab"></div>
        </div>
      </aside>
      <footer class="main-footer">
        <strong>Copyright &copy; <?php echo date("Y") ?> <!-- <a href="http://webmobiledev.com">webmobiledev.com</a> --></strong> Todo los derechos reservados
      </footer>
    </div>
    <script src="../public/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../public/js/vendor/bootstrap.min.js"></script>
    <script src="../public/js/vendor/angular.min.js"></script>
    <script src="../public/js/vendor/angular-animate.min.js"></script>
    <script src="../public/js/vendor/angular-ui-router.min.js"></script>
    <script src="../public/js/vendor/ui-bootstrap-tpls-0.10.0.min.js"></script>
    <script src="../public/js/vendor/anim-in-out.js"></script>
    <script src="../public/js/main_a.js"></script>
    <script src="../public/js/vendor/jquery.slimscroll.min.js"></script>
    <script src="../public/js/app.min.js"></script>
    <script src="../public/js/demo.js"></script>
  </body>
</html>
<?php
   else:
      echo"<script language='javascript'>window.location='../index.php'</script>";
   endif;
?>