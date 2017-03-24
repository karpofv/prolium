<?php
include_once 'includes/layout/headp.php';
require 'includes/conf/general_parameters.php';
ini_set('display_errors', false);
ini_set('display_startup_errors', false);
if ($_GET[logaut] == '1') {
  session_cache_limiter('nocache,private');
  session_name($sess_name);
  session_start();
  $sid = session_id();
  session_destroy();
}
?>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h5 class="logo-name">PROLIUM</h5>

            </div>
            <p>Introduce tus datos e ingresa</p>           
            
            <form class="m-t" role="form" action="index2.php" method="post" enctype="multipart/form-data">
                               <!-- notificacion de error -->
                                <?php if (isset($_GET['error_login'])) {
        $error = $_GET['error_login']; ?>                
                                    <?php
                    }
?>                     
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Usuario" required="" id="user" name="user">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" required="" id="pass" name="pass">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

                <a href="#"><small></small></a>
                <p class="text-muted text-center"><small></small></p>
            </form>
        </div>
    </div>

<?php
include_once("includes/layout/foot.php");
?>