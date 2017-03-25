<?php
    $codigo=$_POST[codigo];
    $zona=$_POST[zon];
    $editar=$_POST[editar];
    $eliminar=$_POST[eliminar];
    $eliminarzd=$_POST[eliminarzd];
    if($editar==""){
        $editar==0;
    } else {
        $editar==1;
    }
    if($eliminarzd!=""){
        $delete = paraTodos::arrayDelete("zond_codigo=$codigo", "zona_estado");
    }
    /*MOSTRAR*/
    if($editar==1 and $zona==""){
        $consulinst = paraTodos::arrayConsulta("*", "zona", "zon_codigo=$codigo");
        foreach($consulinst as $inst){
            $zona=$inst[zon_descripcion];
        }
    }
    /*INSERTAR*/
    if($editar==0 and $eliminar=="" and $zona!=""){
        $inserte = paraTodos::arrayInserte("zon_descripcion", "zona", "'$zona'");
        $zona=null;
    }
    /*EDITAR*/
    if($editar==1 and $zona!=""){
        $update = paraTodos::arrayUpdate("zon_descripcion='$zona'", "zona", "zon_codigo=$codigo");
        $zona=null;
    }
    /*ELIMINAR*/
    if($eliminar==1){
        $delete = paraTodos::arrayDelete("zon_codigo=$codigo", "zona");
    }

?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edición y registro de zonas productivas</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <form id="frmzona" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            zona: $('#zona').val(),
                                                                            dmn: 2,
                                                                            actd: 3,
                                                                            ver:1
                                                                        },
                                                                        ajaxSend: $('#selzona').html(cargando),
                                                                        success: function(html) { $('#selzona').html(html); }
        										                      });">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Nueva zona productiva</label>
                                    <input type="text" class="form-control" id="zona" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white" type="button">Cancelar</button>
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
                <form id="zona_estado" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            estado: $('#selestado').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 2,
                                                                            actd: 1,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#selzona').html(cargando),
                                                                        success: function(html) { $('#selzona').html(html); }
        										                      });">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">Zona productiva</label>
                                    <select class="form-control" id="selzona">
                                        <?php
                                            combos::CombosSelect("1", "$selzona", "zon_codigo, zon_descripcion", "zona", "zon_codigo", "zon_descripcion", "1=1");
                                        ?>
                                    </select>
                                </div>
                               <div class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" type="button" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: $('#selzona').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 2,
                                                                            actd: 2,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#selzona').html(cargando),
                                                                        success: function(html) { $('#selzona').html(html); }
        										                      });">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">Estados</label>
                                    <select class="form-control" id="selestado">
                                        <?php
                                            combos::CombosSelect("1", "$selestado", "est_codigo, est_descripcion", "tools_estados e", "est_codigo", "est_descripcion", " e.est_codigo not in (select zond_est_codigo from zona_estado ze)");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" type="button" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            zona: $('#selzona').val(),
                                                                            estado: $('#selestado').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 2,
                                                                            actd: 3,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#selestado').html(cargando),
                                                                        success: function(html) { $('#selestado').html(html); }
        										                      });">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Zonas registradas</h5>
                <div class="ibox-tools">
                    <a class="collapse-link" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 2,
                                                                            actd: 4,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#instituciones').html(cargando),
                                                                        success: function(html) { $('#instituciones').html(html);             $('#instituciones').DataTable({
                destroy:true
            });}
        										                      });"> <i class="fa fa-refresh"></i> </a>
                    <a class="collapse-link" onclick=""> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <table class="table table-striped table-bordered table-hover " id="instituciones">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Estado</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="body_inst">
                        <?php
                            $consulzona = paraTodos::arrayConsulta("ze.zond_codigo,z.zon_descripcion, e.est_descripcion", "zona z, zona_estado ze, tools_estados e", "z.zon_codigo=ze.zond_zoncodigo and ze.zond_est_codigo=e.est_codigo");
                            foreach($consulzona as $zona){
                        ?>
                        <tr id="tr_<?php echo $zona[zond_codigo]?>">
                            <td><?php echo $zona[zon_descripcion]?></td>
                            <td><?php echo $zona[est_descripcion]?></td>
                            <td><a href="#" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: <?php echo $zona[zond_codigo];?>,
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 2,
                                                                            actd: 5,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#tr_<?php echo $zona[zond_codigo]?>').html(cargando),
                                                                        success: function(html) {
                                                                            $('#tr_<?php echo $zona[zond_codigo]?>').remove();
                                                                            $('#selestado').html(html);
                                                                        }
        										                      });"><i class="fa fa-minus-square"></i></a></td>
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
        $(document).ready(function(){
            $('#instituciones').DataTable({
                pageLength: 25,
                responsive: true
            });

        });

    </script>
