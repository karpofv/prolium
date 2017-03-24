<?php
    $codigo = $_POST[c];
    $codigou = $_POST[cu];
    $ced = $_POST[ced];
    $nombre = $_POST[n];
    $apellido = $_POST[a];
    $correo = $_POST[co];
    $teleff = $_POST[tf];
    $telefm = $_POST[tm];
    $user = $_POST[u];
    $tipo = $_POST[t];
    $pass = $_POST[p];
    $editar = $_POST[editar];
    $eliminar = $_POST[eliminar];
    $eliminar2 = $_POST[eliminar2];
    $dmn = $_POST[dmn];
    /*INSERTAR*/
    if($editar=="" and $nombre!=""){
        $pass = md5($pass);
        $insertar = paraTodos::arrayInserte("per_cedula,per_nombres, per_apellidos, per_correro, per_telefonof, per_telefonom, per_tipo", "persona", "'$ced', '$nombre', '$apellido', '$correo', '$teleff', '$telefm', '$tipo'");
        $insertar = paraTodos::arrayInserte("Cedula, Usuario, Tipo, contrasena, Nivel", "usuarios", "'$ced', '$user', 'Empleado', '$pass', '$tipo'");
    }
    /*UPDATE*/
    if($editar==1 and $nombre!=""){
        $pass = md5($pass);        
        $update = paraTodos::arrayUpdate("per_nombres='$nombre', per_apellidos='$apellido', per_correro='$correo', per_telefonof='$teleff', per_telefonom='$telefm', per_tipo='$tipo'", "persona", "per_codigo=$codigo");
        if($codigou!=""){
            $update = paraTodos::arrayUpdate("Usuario='$user', Nivel='$tipo'", "usuarios", "id=$codigou");            
            if($update){
                paraTodos::showMsg("Actualizacion exitosa", "alert-success");
            }                   
        } else {
            $insertar = paraTodos::arrayInserte("Cedula, Usuario, Tipo, contrasena, Nivel", "usuarios", "'$ced', '$user', 'Empleado', '$pass', '$tipo'");
            if($eliminar){
                paraTodos::showMsg("Actualizacion exitosa", "alert-success");
            }            
        }
        $codigo = "";
        $codigou ="";
        $ced = "";
        $nombre = "";
        $apellido = "";
        $correo = "";
        $teleff = "";
        $telefm = "";
        $user = "";
        $tipo = "";
        $pass = "";
    }
    /*MOSTRAR*/
    if($editar==1 and $nombre==""){
        $consulper = paraTodos::arrayConsulta("*", "persona p left join usuarios u on u.Cedula=p.per_cedula", "p.per_codigo=$codigo");
        foreach($consulper as $per){
            $codigo = $per[per_codigo];
            $codigou = $per[id];
            $ced = $per[per_cedula];
            $nombre = $per[per_nombres];
            $apellido = $per[per_apellidos];
            $correo = $per[per_correro];
            $teleff = $per[per_telefonof];
            $telefm = $per[per_telefonom];
            $user = $per[Usuario];
            $tipo = $per[per_tipo];
        }
    }
    /*ELIMINAR*/
    if($eliminar==1){
        $eliminar = paraTodos::arrayDelete("id=$codigou", "usuarios");
        if($eliminar){
            paraTodos::showMsg("usuario eliminado", "alert-success");
        }
    }
    /*ELIMINAR*/
    if($eliminar2==1){
        $eliminar = paraTodos::arrayDelete("id=$codigou", "usuarios");        
        $eliminar = paraTodos::arrayDelete("per_codigo=$codigo", "persona");        
    }
?>
<div class="container-fluid">
    <div class="form-group">
            <form class="form-horizontal" id="formulario" onsubmit="
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            editar: '<?php echo $editar?>', 
                                                                            c: $('#codigo').val(), 
                                                                            cu: $('#codigou').val(), 
                                                                            ced: $('#txtcedula').val(), 
                                                                            n: $('#txtnombre').val(), 
                                                                            a: $('#txtapellido').val(), 
                                                                            co: $('#txtcorreo').val(), 
                                                                            tf: $('#txttlff').val(), 
                                                                            tm: $('#txttlfm').val(), 
                                                                            u: $('#txtusuario').val(), 
                                                                            t: $('#seltipo').val(), 
                                                                            p: $('#txtpass').val(), 
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            ver: 2                                                                     
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      }); return false" action="javascript: void(0);" method="post">       
            <div class="card">
                <div class="card-header"> Usuarios </div>
                <div class="card-body">
                    <div class="row">
                        <div class="" id="datosgen">
                            <div class="">
                                <div class="col-sm-5 col-md-2">
                                    <label class="control-label">Cédula</label>
                                    <input type="number" class="form-control" id="txtcedula" value="<?php echo $ced;?>" required>
                                    <input type="text" class="form-control collapse" id="codigo" value="<?php echo $codigo;?>"> </div>
                                <div class="col-sm-6 col-md-5">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="txtnombre" value="<?php echo $nombre;?>" required> </div>
                                <div class="col-sm-6 col-md-5">
                                    <label class="control-label">Apellido</label>
                                    <input type="text" class="form-control" id="txtapellido" value="<?php echo $apellido;?>" required> </div>
                            </div>
                            <div class="">
                                <div class="col-sm-12 col-md-4">
                                    <label class="control-label">Correo</label>
                                    <input type="text" class="form-control" id="txtcorreo" value="<?php echo $correo;?>" required> </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="control-label">Télefono Fijo</label>
                                    <input type="text" class="form-control" id="txttlff" value="<?php echo $teleff;?>" required> </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="control-label">Teléfono Movil</label>
                                    <input type="text" class="form-control" id="txttlfm" value="<?php echo $telefm;?>" required> </div>
                            </div>
                        </div>
                        <div class="" id="datosusuario">
                            <div class="col-sm-4 col-md-2">
                                <label class="control-label">Usuario</label>
                                <input type="text" class="form-control" id="txtusuario" value="<?php echo $user;?>" required>
                                <input type="text" class="form-control collapse" id="codigou" value="<?php echo $codigou;?>"> </div>
                            <div class="col-sm-4 col-md-2">
                                <label class="control-label">Contraseña</label>
                                <input type="password" class="form-control" id="txtpass" value="<?php echo $pass;?>"> </div>
                            <div class="col-sm-4 col-md-2">
                                <label class="control-label">Tipo de Usuario</label>
                                <select class="form-control selectnw" id="seltipo">
                                    <?php
                                        combos::CombosSelect("1",$tipo,"CodPerfil, Nombre", "perfiles", "CodPerfil", "Nombre", "CodPerfil<>3");
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-default btnopera" id="btnsave">GUARDAR</button>
                <button type="button" class="btn btn-default btnopera" onclick="cancel();">CANCELAR</button>
            </div>
        </form>
    </div>
    <div class="form-group">
        <div class="card">
            <div class="card-header"> Usuarios registrados </div>
            <div class="card-body no-padding">
                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Cédula</th>
                            <th>Usuario</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Telefono fijo</th>
                            <th>Telefono Movil</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th>Eliminar Todo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $consuluser = paraTodos::arrayConsulta("*", "perfiles pf,persona p left join usuarios u on u.Cedula=p.per_cedula", "p.per_tipo=pf.CodPerfil and CodPerfil<>3");
                            foreach($consuluser as $user){
                        ?>
                            <tr>
                                <td><?php echo $user[Nombre]?></td>
                                <td><?php echo $user[per_cedula]?></td>
                                <td><?php echo $user[Usuario]?></td>
                                <td><?php echo $user[per_nombres]?></td>
                                <td><?php echo $user[per_apellidos]?></td>
                                <td><?php echo $user[per_correro]?></td>
                                <td><?php echo $user[per_telefonof]?></td>
                                <td><?php echo $user[per_telefonom]?></td>
                                <td><a href="javascript:void(0)"  onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            c: '<?php echo $user[per_codigo]?>',
                                                                            cu: '<?php echo $user[id]?>',
                                                                            editar: 1,
                                                                            ver: 2                                     
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });"><i class="fa fa-edit"></i></a></td>
                                <td><a href="javascript:void(0)"  onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            c: '<?php echo $user[per_codigo]?>',
                                                                            cu: '<?php echo $user[id]?>',
                                                                            eliminar: 1,
                                                                            ver: 2 
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });"><i class="fa fa-remove font-red"></i></a></td>
                                <td><a href="javascript:void(0)"  onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            c: '<?php echo $user[per_codigo]?>',
                                                                            cu: '<?php echo $user[id]?>',
                                                                            eliminar2: 1,
                                                                            ver: 2 
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });"><i class="fa fa-remove font-red"></i></a></td>
                            </tr>
                        <?php
                                
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(".datatable").DataTable({
        "scrollX": true
    });
    function cancel(){
        $.ajax({
            type: 'POST',
            url: 'accion.php',
            data: {
                dmn: <?php echo $idMenut; ?>,
                ver: 2                                     
            },
            ajaxSend: $('#page-content').html(cargando),                                                    
            success: function(html) { $('#page-content').html(html); }
        });
    }
</script>