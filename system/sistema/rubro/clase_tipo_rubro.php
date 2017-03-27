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
                <h5>Edición y registro de rubros</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <form id="frmrubro" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            rubro: $('#rubro').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act : 10,
                                                                            actd: 1,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#selrubro').html(cargando),
                                                                        success: function(html) { $('#selrubro').html(html); }
        										                      });">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Nuevo rubro</label>
                                    <input type="text" class="form-control" id="rubro" required>
                                    <input type="number" class="collapse" id="codigo">
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
                <form id="rubro_tipo" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            rubro: $('#selrubro').val(),
                                                                            tiprub: $('#tiprubro').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 10,
                                                                            actd: 3,
                                                                            ver:2
                                                                        },
                                                                        success: function(html) {
                                                                            actualizar();
                                                                        }
        										                      });">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">Rubros</label>
                                    <select class="form-control" id="selrubro">
                                        <?php
                                            combos::CombosSelect("1", "$selrubro", "rub_codigo, rub_descripcion", "rubros", "rub_codigo", "rub_descripcion", "1=1 order by rub_descripcion");
                                        ?>
                                    </select>
                                </div>
                               <div class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" type="button" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: $('#selrubro').val(),
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 10,
                                                                            actd: 2,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#selrubro').html(cargando),
                                                                        success: function(html) { 
                                                                            $('#selrubro').html(html);
                                                                            actualizar();
                                                                        }
        										                      });">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">Tipo de rubro</label>
                                    <input type="text" id="tiprubro" class="form-control" required>
                                </div>
                                <div class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" type="submit">Agregar</button>
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
                <h5>Tipos de rubros</h5>
                <div class="ibox-tools">
                    <a class="collapse-link" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 10,
                                                                            actd: 4,
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#tipos_rubros').html(cargando),
                                                                        success: function(html) { 
                                                                            $('#tipos_rubros').DataTable({
                                                                                destroy:true
                                                                            });                                                      
                                                                            $('#tipos_rubros').html(html); 
                                                                        }
        										                      });"> <i class="fa fa-refresh"></i> </a>
                    <a class="collapse-link" onclick=""> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <table class="table table-striped table-bordered table-hover " id="tipos_rubros">
                    <thead>
                        <tr>
                            <th>Rubros</th>
                            <th>Tipos de rubros</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="body_inst">
                        <?php
                            $consulrubro = paraTodos::arrayConsulta("*", "rubros r, tipo_rubro tp", "tp.tipr_rubcodigo=r.rub_codigo order by rub_descripcion");
                            foreach($consulrubro as $rubro){
                        ?>
                        <tr id="tr_<?php echo $rubro[tipr_codigo]?>">
                            <td><?php echo $rubro[rub_descripcion]?></td>
                            <td><?php echo $rubro[tipr_descripcion]?></td>
                            <td><a href="#" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: <?php echo $rubro[tipr_codigo];?>,
                                                                            dmn: <?php echo $idMenut?>,
                                                                            act: 10,
                                                                            actd: 5,
                                                                            ver:2
                                                                        },
                                                                        success: function(html) {
                                                                            actualizar();
                                                                            $('#tr_<?php echo $rubro[tipr_codigo]?>').remove();
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
            $('#tipos_rubros').DataTable({
                pageLength: 10,
                responsive: true
            });

        });
    function actualizar(){
                                                                            $.ajax({
                                                                                type: 'POST',
                                                                                url: 'accion.php',
                                                                                data: {
                                                                                    dmn: <?php echo $idMenut?>,
                                                                                    act: 10,
                                                                                    actd: 4,
                                                                                    ver:2
                                                                                },
                                                                                ajaxSend: $('#tipos_rubros').html(cargando),
                                                                                success: function(html) { 
                                                                                    $('#tipos_rubros').DataTable({
                                                                                        destroy:true
                                                                                    });                                                      
                                                                                    $('#tipos_rubros').html(html); 
                                                                                }
                                                                            });         
    }
    </script>
