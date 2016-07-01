<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>GMZBol</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/AdminLTE.css">
    <link rel="shortcut icon" href="public/img/icon.png">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <strong><b>GMZ</b>Bol<br>
        <p style="font-size: 14px">INGENIERIA MULTIDISCIPLINARIA</p></strong>
        <!-- <img src="public/img/avatar.png"> -->
      </div>
      <div class="login-box-body">
        <h4 class="login-box-msg text-primary">INICIAR SESSION</h4>
        <?php
          //echo md5(sha1(('dcfvgbhnj')));
          error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_ERROR);
          require_once"lib/conexionl.php";
          require_once"lib/funcionl.php";
          if(isset($_POST['send'])):
              $usuario = filter_input(INPUT_POST, "username",FILTER_SANITIZE_MAGIC_QUOTES);
              $contra = filter_input(INPUT_POST, "userpass",FILTER_SANITIZE_MAGIC_QUOTES);
              $changem = filter_input(INPUT_POST, "usercot",FILTER_SANITIZE_MAGIC_QUOTES);
              $l = new login;
              $l->setUser($usuario);
              $l->setPass(md5(sha1($contra)));
              $l->setCoti($changem);
              if($l->entrar()):
                if ($_SESSION['utype']=='a') {
                  echo"<script language='javascript'>window.location='intra/initial.php'</script>";
                }
                else {
                  if ($_SESSION['utype']=='o' && $_SESSION['uesta']==1) {
                    echo"<script language='javascript'>window.location='inter/initial.php'</script>";
                  }
                  else{
                    echo"<script language='javascript'>window.location='index.php?nota=Usuario bloqueado'</script>";
                    unset($_SESSION['dentro']);
                    session_destroy();
                  }
                }
              else:
                echo"<script language='javascript'>window.location='index.php?nota=Usuario no autorizado'</script>";
              endif;
          endif;
          ?>
        <form method="POST">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Usuario" autocomplete="off" required autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="userpass" class="form-control" placeholder="Contraseña" autocomplete="off" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="usercot" class="form-control" placeholder="Cotización" value="6.96" autocomplete="off" required>
            <span class="glyphicon glyphicon-usd form-control-feedback"></span>
          </div><hr>
          <div class="form-group text-center">
            <button type="submit" name="send" class="btn btn-lg btn-primary btn- btn-flat"><span class="glyphicon glyphicon-ok"></span>&nbsp; <i>INGRESAR</i></button>
          </div>
          <div class="text-center">
            <?php
              error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
              if (isset($_GET["nota"])) {
                echo "<span style='color: #ff0000;'><b>".$_GET["nota"]."</b></span>";
              }
            ?>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>