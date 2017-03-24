<?php
	error_reporting(E_ALL);
	ini_set('display_errors', false);
	ini_set('display_startup_errors', false);
	require_once ('includes/conf/db.php');
	require_once ('includes/conexion.php');
	require_once ('system/modelo/usuarios/class.usuarios.php');
	// $usuario = $_POST['usuario'];
	// $cedula = $_POST['cedula'];
	// $contrasena = md5($_POST['contrasena']);
	// $tipo = "Empleado";
	if ($_REQUEST) {
  		$usuario = $_POST['usuario'];
  		$cedula = $_POST['cedula'];
  		$contrasena = md5($_POST['contrasena']);
  		$recontrasena = md5($_POST['recontrasena']);
  		$tipo = "Empleado";
  		if ($contrasena != $recontrasena){
    		echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('Las contraseñas introducidas no cohinciden');
    		javascript:window.history.back();
    		</SCRIPT>");
    		exit;
  		}
  		$validaCedulaAsoc = UsuariosModel::comprobarCedulaAsoc($cedula);
  		if ($validaCedulaAsoc == 1){
    		$validaCedulaUsu = UsuariosModel::comprobarCedulaUsu($cedula);
  		}else {
    		echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('Disculpe pero la cedula introducida no se encuentra en nuestra base de datos')
    		javascript:window.history.back();
    		</SCRIPT>");
    		exit;
  		}
  		$validaCedulaUsu = UsuariosModel::comprobarCedulaUsu($cedula);
  		if (!$validaCedulaUsu == 1) {
    		$validaUsu = UsuariosModel::validaUsu($usuario);
  		}else{
    		echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('La cedula $cedula Ya posee un usuario registrado')
    		javascript:window.history.back();
    		</SCRIPT>");
    		exit;
  		}
  		$validaUsu = UsuariosModel::validaUsu($usuario);
  		if (!$validaUsu == 1) {
    		$usuariomodel = UsuariosModel::registrarUsuario($cedula,$usuario,$contrasena,$tipo,$registro);
    		echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('Usuario registrado exitosamente');
    		javascript:window.history.back();
    		</SCRIPT>");
  		}else{
    		echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('El usuario $usuario no se encuentra disponible, por favor intenta con otro')
    		javascript:window.history.back();
    		</SCRIPT>");
			exit;
		}
	}
?>
