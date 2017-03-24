<?php
////////////////////////////////////////////////////////
$permiso=$_SESSION['usuario_login'];
if($permiso==""){
    $permiso=$_POST['very'];
}
$fdia=date('d');
$fmes=date('m');
$fano=date('y');
$hora=Date("h:i:s");
$fechaest=$fdia."/".$fmes."/".$fano;
$fechaest="$fechaest".":"."$hora";

$nusuario=$_POST['nusuario'];
$nclave=md5($_POST['nclave']);
$apellidos=$_POST['apellido'];
$cedula=$_POST['cedula'];
$idperfil=$_POST['idperfil'];
$borrar=$_POST['ir'];
$editarr=$_POST['editar'];
$editarrt=$_POST['editarr'];
$alsede=$_POST['sede'];
$cargo=$_POST['depart'];
$mens="Este modulo es para crear o eliminar los usuarios, control de permisos de entrada y salida";

$usuario=$_GET['usuari'];
$clave=$_GET['contan'];
$desbloq=$_GET['desbloq'];
if ($permiso_accion['S']==1 AND $permiso_accion['I']==1 AND $permiso_accion['U']==1 AND $permiso_accion['D']==1) {
    if ($nusuario<>"" and $nclave<>"" and $idperfil<>'0' and $idperfil<>'' and $editarrt=="" and $_POST[nombre]!="" and $_POST[apellido]!="" and $_POST[cedula]!=''){
       $resultx=mysql_query("select id from usuarios where ((Usuario like '%".$nusuario."%'))");
       while($row = mysql_fetch_array($resultx)) {
         $verususd='<h3 class="error">Usuario ya esta registrado</h3>';
       }
       mysql_free_result($resultx);

       if($verususd<>"") {
          echo $verususd;
       } else {
            $insertar = "INSERT INTO usuarios (Cedula,Usuario,Contrasena,CodSede,Tipo,Nivel) VALUES ('$cedula','$nusuario','$nclave','$alsede','Empleado','$idperfil')";
            if  ($result = mysql_query ($insertar)) {
                echo '<h3 class="message">Usuario creado</h3>';
                $resultx=mysql_query("select id from usuarios where Usuario = '$nusuario'");
               while($row = mysql_fetch_array($resultx)) {
                 $idUsua=$row[id];
               }mysql_free_result($resultx);
               $insertar = "INSERT INTO registrados (cedula,Usuario,Apellidos,Nombres,correo) VALUES ('$_POST[cedula]','$idUsua','$_POST[apellido]','$_POST[nombre]','$_POST[correo]')";
               if  ($result = mysql_query ($insertar)) {
                    $correou=$_POST[correo];
                    $headers  = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                    $headers .= "To: $correou \r\n";
                    $headers .= "From: SICA <info@igsve.com>\r\n";
                    $headers .= "Cc: \r\n";
                    $headers .= "Bcc: \r\n";
                    $elcontenido = '<div style="width: 645px;overflow: hidden;font-family: Arial;border: 1px solid #EEEEEE;background: #F9F9F9;">
                        <img src="http://www.igsve.com/alimentos/publicidad/headercorreo.png" border="0" />
                        <div style="overflow: hidden;background: #FFFFFF;margin-left: 20px;margin-top: 15px;width: 602px;text-align: left;font-family: Arial;font-size: 1.100em;border-top: 2px solid #EEEEEE;border-left: 2px solid #EEEEEE;border-right: 2px solid #EEEEEE;">
                        <div style="width: 100%;text-align: center;font-size: 1.100em;font-family: Arial;font-weight: bold;margin-bottom: 20px;">
                            <U>Clave de Acceso Creada</U>
                        </div>
                        <div style="margin-left: 10px;width: 620px;text-align: left;font-family: Arial;font-size: 0.900em;">
                        <b>SICA</b>, te da la bienvenida, tus datos de acceso son los siguientes:<br><br>
                        <b>Usuario :</b> '.$nusuario.'<br>
                        <b>Clave   :</b> '.$_POST[nclave].'<br><br>
                            Entrar al Sistema de Alimentos :<a href="http://www.igsve.com/alimentos">SICA</a>
                        </div>
                            <br>
                        </div>
                        <div style="background: #F3F3F3;width: 645px;height: auto;text-align: center;">
                            <img src="http://www.igsve.com/alimentos/publicidad/footercorreo.png" border="0" />
                        </div>
                    </div>';
                    //mail($correou, "Acceso Creado para el Sistema SICA", $elcontenido,$headers)or die('Error enviando correo');
               }else{
                    echo "<h3 class=\"error\">No se proceso los datos, del Registro</h3>";
               }
       }else{
            echo "<h3 class=\"error\">No se proceso los datos, del Registro</h3>";
       }
      }
    }

    if ($idperfil<>'0' and $idperfil<>'' and $editarrt!="" and $_POST[nombre]!="" and $_POST[apellido]!="" and $_POST[cedula]!='' and $_POST[correo]!=''){
        $modifico = "UPDATE usuarios SET  Nivel='$idperfil' WHERE id=$editarrt";
        if  ($result = mysql_query ($modifico)) {

        } else {
            echo '<h3 class="error">Error Modificando Registro</h3>';
        }
        $modifico = "UPDATE registrados SET  Apellidos='$_POST[apellido]',Nombres='$_POST[nombre]',correo='$_POST[correo]' WHERE (cedula='$_POST[cedula]')";
            if  ($result = mysql_query ($modifico)) {
                echo '<h3 class="message">Registro Modificado</h3>';
            } else {
            }
    }

    $verususd="";
    if ($borrar<>"") {
        $insertar = "delete from usuarios where id = $borrar";
        if ($res=mysql_query ($insertar)) {
            echo '<h3 class="message">Usuario eliminado</h3>';
            $mater="$cedula : $cargo : $nusuario : $nombre_perfil";
            $cedula='';
            $nusuario='';
        }

    }
    if ($editarr!=""){
       $resultsedes=mysql_query("select * from usuarios where ((id = '$editarr'))");
        while($rowses = mysql_fetch_array($resultsedes)) {
            $idperfil=$rowses["Nivel"];
            $cemp=$rowses["Cedula"];
            $ucemp=$rowses["Usuario"];
            $resultsede=mysql_query("select Nombres,Apellidos,correo from registrados where cedula = '$cemp'");
            while($rowse = mysql_fetch_array($resultsede)) {
                $apnomb=$rowse["Nombres"]; $apnomba=$rowse["Apellidos"]; $correo=$rowse["correo"];
            }
            mysql_free_result($resultsede);
         }
        mysql_free_result($resultsedes);
    }
}
?>
<div style="width: 70%;border: 1px solid #CCCCCC;background: #FFFFFF;margin: 0px auto 0px auto;">
<?php
if ($permiso_accion['S']==1 AND $permiso_accion['I']==1 AND $permiso_accion['U']==1 AND $permiso_accion['D']==1) {
if ($_POST['editar']!='') { ?>
    <FORM onsubmit="$.ajax({ type: 'POST', url: 'busco.php',
    data: {
        cedula      : $('#cedula').val(),
        apellido    : $('#apellido').val(),
        nombre      : $('#nombre').val(),
        correo      : $('#correo').val(),
        nusuario    : $('#nusuario').val(),
        nclave      : $('#nclave').val(),
        idperfil    : $('#idperfil').val(),
        idsubmenu   : <?php echo $idsubmenu; ?>,
        editarr     : <?php echo $_POST['editar']; ?>
    },
    success: function(html) {   $('#page-content').html(html); },
    error: function(xhr,msg,excep) { alert('Error Status ' + xhr.status + ': ' + msg + '/ ' + excep); }
    }); return false" action="javascript: void(0);" method="post">
    <?php
}else{ ?>
    <FORM onsubmit="$.ajax({ type: 'POST', url: 'busco.php',
    data: {
        cedula      : $('#cedula').val(),
        apellido    : $('#apellido').val(),
        nombre      : $('#nombre').val(),
        correo      : $('#correo').val(),
        nusuario    : $('#nusuario').val(),
        nclave      : $('#nclave').val(),
        idperfil    : $('#idperfil').val(),
        idsubmenu   : <?php echo $idsubmenu; ?>
    },
    success: function(html) {   $('#page-content').html(html); },
    error: function(xhr,msg,excep) { alert('Error Status ' + xhr.status + ': ' + msg + '/ ' + excep); }
    }); return false" action="javascript: void(0);" method="post">
    <?php
}   ?>
    <table cellSpacing="1" cellPadding="2" style="width: 100%;">
    <tr>
    <th colSpan="2" style="width: 100%;padding: 10px 6px 10px 6px;background: #FAFAFA;border: 1px solid #DDDDDD;"> Ingresar Datos del Empleado </th>
    </tr>
    <tr>
        <td style="height: 30px;padding: 8px;" width="220" height="10">
      		C&eacute;dula:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input class="gen_input" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="12" size="10" name="cedula" id="cedula" value="<?php printf("%s",$cemp);?>" required="required" >
	</td>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 8px;" width="220" height="10">
      	Nombres:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input  type="text" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="100" size="60" name="nombre" id="nombre" value="<?php printf("%s",$apnomb);?>" required="required" >
	</td>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 8px;" width="220" height="10">
      	Apellidos:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input  type="text" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="100" size="60" name="apellido" id="apellido" value="<?php printf("%s",$apnomba);?>" required="required" >
	</td>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 8px;" width="220" height="10">
      	Correo:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input type="email" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="100" size="60" name="correo" id="correo" value="<?php printf("%s",$correo);?>" required="required" >
	</td>
    </tr>
	
    <tr>
      	<th colSpan="2" style="width: 100%;padding: 6px;background: #FAFAFA;border: 1px solid #DDDDDD;">
      	Ingresar Usuario
	</th>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 8px;" width="220" height="10">
      	Usuario:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input  type="text" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="10" size="10" name="nusuario" id="nusuario" value="<?php printf("%s",$ucemp);?>" required="required" >
	</td>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 8px;" width="220" height="10">
      	Contrase&ntilde;a:
	</td>
      	<td style="height: 30px;padding: 8px;" width="489" height="10">
      	<input  type="text" style="font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;" maxLength="10" size="10" name="nclave" id="nclave" type="password" <?php if ($_POST['editar']=="") { ?> required="required" <?php } ?> >
	</td>
    </tr>
    <tr>
      	<th colSpan="2" style="width: 100%;padding: 6px;background: #FAFAFA;border: 1px solid #DDDDDD;">
      	Perfil del Usuario
	</th>
    </tr>
    <tr>
      	<td style="height: 30px;padding: 15px 8px 15px 8px;" width="220" height="10">
      	Perfil:
	</td>
          <td style='height: 30px;padding: 15px 8px 15px 8px;'>
          <select style='font-family: Arial; height: 33px;padding: 7px;border: 1px solid #DDDDDD;' id="idperfil" name="idperfil" required="required">
              <option value="0">Seleccione el Perfil</option><?php Combos::CombosPerfil($permiso,$idperfil); ?>
            </select>
          </td>
    </tr>
    <tr>
        <th colSpan="2" style="width: 100%;padding: 6px;background: #FAFAFA;border: 1px solid #DDDDDD;">
        <button class="btn btn-primary popover-button"  type="submit" name="Grabar" value="Enviar">Enviar</button>
        </th>
    </tr>
</table>
</FORM>
<?php } ?>
</div>
<?php
if ($permiso_accion['S']==1) {
$resultc=mysql_query("select usuarios.id,usuarios.Cedula,usuarios.Usuario,registrados.Nombres,registrados.Apellidos,registrados.correo,
    usuarios.Nivel from usuarios,registrados where usuarios.Tipo='Empleado'
    and registrados.cedula=usuarios.Cedula
    order by registrados.Nombres"); ?>
<div style="width: 90%;border: 1px solid #CCCCCC;background: #FFFFFF;margin: 10px auto 0px auto;">
<table cellSpacing="1" cellPadding="2" style="width: 100%;">
    <tr>
    	<th colSpan="5" style="width: 100%;padding: 6px;background: #FAFAFA;border: 1px solid #DDDDDD;">
      	Usuarios Registrados
	</th>
   </tr>
    <?php
    while($rowc = mysql_fetch_array($resultc)) {
      $borra=$rowc["id"];
      $editar=$rowc["id"];
      $cdemp=$rowc["Cedula"];
      $nnusuario=$rowc["Usuario"];
      $nnclave=$rowc["Nivel"];
      $nombperfil='';
      $resultq1d=mysql_query("select Nombre from perfiles where CodPerfil=$nnclave");
      while($rowq1d = mysql_fetch_array($resultq1d)) {
        $nombperfil=$rowq1d["Nombre"];
       }
       mysql_free_result($resultq1d);
      ?>
      <TR style="border-bottom: 1px solid #EEEEEE;">
      <TD style="padding: 15px 7px 15px 7px;"><B> <?php printf("%s",$nnusuario);?></B></TD>
      <TD><B><?php echo $rowc["Cedula"]; ?> : <?php echo $rowc["Nombres"]; ?>, <?php echo $rowc["Apellidos"]; ?><br><?php echo $rowc["correo"]; ?></B></TD>
      <TD><B class="btn btn-primary popover-button"><?php echo $nombperfil; ?></B></TD>
      <TD>
        <?php
        if ($permiso_accion['S']==1 AND $permiso_accion['I']==1 AND $permiso_accion['U']==1 AND $permiso_accion['D']==1) { ?>
        <a title="Asignar permisos"
        onclick="$.ajax({ type: 'POST', url: 'busco.php', ajaxSend: $('#verMas').html(cargando),
        data: 'bodega=<?php echo $row[Id]; ?>&CedulaPerm=<?php echo $rowc[Cedula]; ?>&M=2&idsubmenu=<?php echo $idsubmenu; ?>',
        success: function(html) { $('#verMas').html(html); },
        error: function(xhr,msg,excep) { alert('Error Status ' + xhr.status + ': ' + msg + '/ ' + excep); }
        }); return false;" href="javascript: void(0);">
        <i class="glyph-icon icon-archive opacity-80" style="font-size: 1.400em;"></i>
        </a>
        <a title="Editar el registro"
        onclick="$.ajax({ type: 'POST', url: 'busco.php', ajaxSend: $('#page-content').html(cargando),
        data: 'editar=<?php echo $rowc[id]; ?>&idsubmenu=<?php echo $idsubmenu; ?>',
        success: function(html) { $('#page-content').html(html); },
        error: function(xhr,msg,excep) { alert('Error Status ' + xhr.status + ': ' + msg + '/ ' + excep); }
        }); return false;" href="javascript: void(0);"><i class="glyph-icon icon-edit opacity-80" style="font-size: 1.600em;margin-left: 10px;"></i></a>
        <a onclick=" var msg = confirm('Esta seguro que desea eliminar el registro?');
        if (msg) {
        $.ajax({ type: 'POST', url: 'busco.php', ajaxSend: $('#page-content').html(cargando),
        data: 'ir=<?php echo $rowc[id]; ?>&idsubmenu=<?php echo $idsubmenu; ?>',
        success: function(html) { $('#page-content').html(html); }
        });  } return false;" href="javascript: void(0);" title="Eliminar el registro">
        <i class="glyph-icon icon-remove opacity-80" style="font-size: 1.600em;margin-left: 10px;"></i>
        </a>
      <?php } ?>
      </TD></TR>
      <?php
      $rtwer=""; $apnomb="";
    }
    mysql_free_result($resultc);    ?>
</table>
</div>
<?php } ?>
 <br>

