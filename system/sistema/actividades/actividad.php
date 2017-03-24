<?php
    $codigo = $_POST[c];
    $activi = $_POST[a];
    $abrev = $_POST[ab];
    $resp = $_POST[r];
    $editar = $_POST[editar];
    $eliminar = $_POST[eliminar];
    $dmn = $_POST[dmn];
    /*INSERTAR*/
    if($editar=="" and $activi!=""){
        $insertar = paraTodos::arrayInserte("act_descrip, act_abreviatura, act_responsable", "actividad", "'$activi', '$abrev', '$resp'");
        if($insertar){
            paraTodos::showMsg("Actualizacion exitosa", "alert-success");
        }     
        $codigo = "";
        $carrera ="";                                     
    }
    /*UPDATE*/
    if($editar==1 and $activi!=""){
        $update = paraTodos::arrayUpdate("act_descrip='$activi', act_abreviatura='$abrev', act_responsable='$resp'", "actividad", "act_codigo=$codigo");
        if($update){
            paraTodos::showMsg("Actualizacion exitosa", "alert-success");
        }     
        $codigo = "";
        $activi = "";
        $abrev = "";
        $resp = "";
    }
    /*MOSTRAR*/
    if($editar==1 and $activi==""){
        $consulactiv = paraTodos::arrayConsulta("*", "actividad a, actividad_resp ar", "a.act_responsable=ar.actr_codigo and a.act_codigo=$codigo");
        foreach($consulactiv as $activ){
            $activi = $activ[act_descrip];
            $abrev = $activ[act_abreviatura];
            $resp = $activ[actr_codigo];
        }
    }
    /*ELIMINAR*/
    if($eliminar==1){
        $eliminar = paraTodos::arrayDelete("act_codigo=$codigo", "actividad");
        if($eliminar){
            paraTodos::showMsg("actividad eliminada", "alert-success");
        }
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
                                                                            a: $('#txtactivi').val(),
                                                                            ab: $('#txtabrevia').val(),
                                                                            r: $('#selresp').val(),
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            ver: 2                                                                     
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      }); return false" action="javascript: void(0);" method="post">       
            <div class="card">
                <div class="card-header"> Actividades </div>
                <div class="card-body">
                    <div class="row">
                        <div class="" id="datosgen">
                            <div class="">
                                <div class="col-sm-8">
                                    <label class="control-label">Actividad</label>
                                    <input type="text" class="form-control" id="txtactivi" value="<?php echo $activi;?>" required>
                                    <input type="text" class="form-control collapse" id="codigo" value="<?php echo $codigo;?>"> </div>                                
                                <div class="col-sm-2">
                                    <label class="control-label">Abreviatura</label>                                    
                                    <input type="text" class="form-control" id="txtabrevia" value="<?php echo $abrev;?>" required>                                    
                                </div>                                
                                <div class="col-sm-2">
                                    <label class="control-label">Rol responsable</label>                                    
                                    <select class="form-control selectnw" id="selresp">
                                        <?php
                                            combos::CombosSelect("1",$resp,"actr_codigo, actr_descripcion", "actividad_resp", "actr_codigo", "actr_descripcion", "actr_codigo>0 and actr_codigo<4");
                                        ?>
                                    </select>                                    
                                </div>
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
            <div class="card-header"> Actividades registradas </div>
            <div class="card-body no-padding">
                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Abreviatura</th>
                            <th>Responsable</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $consulactiv = paraTodos::arrayConsulta("*", "actividad a, actividad_resp ar", "a.act_responsable=ar.actr_codigo");
                            foreach($consulactiv as $activ){
                        ?>
                            <tr>
                                <td><?php echo $activ[act_descrip]?></td>
                                <td><?php echo $activ[act_abreviatura]?></td>
                                <td><?php echo $activ[actr_descripcion]?></td>
                                <td><a href="javascript:void(0)"  onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut; ?>,
                                                                            c: '<?php echo $activ[act_codigo]?>',
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
                                                                            c: '<?php echo $activ[act_codigo]?>',
                                                                            eliminar: 1,
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
    $(".datatable").DataTable();
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