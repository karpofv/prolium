<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edición y registro de tipo de rubros</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Seleccionar Rubro</label>
                                    <button class="btn btn-default" onclick="$.ajax({
                                                        type: 'POST',
                                                        url: 'accion.php',
                                                        data: {
                                                            dmn: <?php echo $idMenut?>,
                                                            act: 2,
                                                            ver:2
                                                        },
                                                        ajaxSend: $('#ventanaVer').html(cargando),
                                                        success: function(html) {
                                                            $('#ventanaVer').html(html);
                                                        }
                                                  });">BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <label>Rubro :</label><span id="lblrubro"></span>                        
                            <input type="number" class="collapse" id="codigo">
                        </div>
                        <div class="col-xs-6">
                            <label>Tipo de rubro :</label><span id="lbltprubro"></span>
                        </div>
</div>
                    <div class="hr-line-dashed"></div>
                    <div id="datossave" class="form-group collapse">
                        <form id="frmclase" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="
                                                                                                                         $.ajax({
                                                                                type: 'POST',
                                                                                url: 'accion.php',
                                                                                data: {
                                                                                    tprubro: $('#codigo').val(),
                                                                                    clase: $('#clase').val(),
                                                                                    dmn: <?php echo $idMenut?>,
                                                                                    act: 10,
                                                                                    actd: 6,
                                                                                    ver:2
                                                                                },
                                                                                ajaxSend: $('#selclase').html(cargando),
                                                                                success: function(html) {
                                                                                    actualizar();
                                                                                    $('#selclase').html(html);
                                                                                }
                                                                              });">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Nueva clase</label>
                                            <input type="text" class="form-control" id="clase" required>
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
                        <div class="form-group">
                            <div class="col-sm-10">    
                                <label class="control-label">Clases registradas</label>
                                <select id="selclase" class="form-control">
                                    <?php
                                        combos::CombosSelect("1", "$selclase", "tiprc_codigo, tiprc_descripcion", "tiprub_clase", "tiprc_codigo", "tiprc_descripcion", "tiprc_tiprcodigo order by tiprc_descripcion");
                                    ?>                        
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <br>
                                <button class="btn btn-primary" type="button" onclick="$.ajax({
                                                                    type: 'POST',
                                                                        url: 'accion.php',
                                                                            data: {
                                                                                codigo: $('#selclase').val(),
                                                                                dmn: <?php echo $idMenut?>,
                                                                                act: 10,
                                                                                actd: 2,
                                                                                ver:2
                                                                            },
                                                                            ajaxSend: $('#selzona').html(cargando),
                                                                            success: function(html) { $('#selzona').html(html); }
                                                                          });">Eliminar</button>
                            </div>
                            <form id="frmcatego" method="post" class="form-horizontal" action="javascript: void(0)" onsubmit="
                                                                                                                         $.ajax({
                                                                                type: 'POST',
                                                                                url: 'accion.php',
                                                                                data: {
                                                                                    clase: $('#selclase').val(),
                                                                                    categ: $('#txtcatego').val(),
                                                                                    dmn: <?php echo $idMenut?>,
                                                                                    act: 10,
                                                                                    actd: 11,
                                                                                    ver: 2
                                                                                },
                                                                                success: function(html) {
                                                                                    actualizar();
                                                                                }
                                                                              });">
                                <div class="col-sm-10">    
                                    <label class="control-label">Categoría</label>
                                    <input type="text" class="form-control" id="txtcatego" required>
                                </div>
                                <div class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" type="submit">Agregar</button>
</div>
                            </form>                                
                        </div>
</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Clase y categoría de rubros</h5>
                <div class="ibox-tools">
                    <a class="collapse-link" onclick="actualizar();"> <i class="fa fa-refresh"></i> </a>
                    <a class="collapse-link" onclick=""> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <table class="table table-striped table-bordered table-hover " id="rubro_clase">
                    <thead>
                        <tr>
                            <th>Rubros</th>
                            <th>Tipos de rubros</th>
                            <th>Clase</th>
                            <th>Categoría</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="body_inst">
                        <?php
                            $consulrubro = paraTodos::arrayConsulta("*", "tipo_rubro tp, rubros r, tiprub_clase c left join tiprubcl_catego on tiprubcl_tiprubcodigo=c.tiprc_codigo", "r.rub_codigo=tp.tipr_rubcodigo and c.tiprc_tiprcodigo=tp.tipr_codigo order by rub_descripcion");
                            foreach($consulrubro as $rubro){
                        ?>
                            <tr id="tr_<?php echo $rubro[tiprc_codigo]?>">
                                <td>
                                    <?php echo $rubro[rub_descripcion]?>
                                </td>
                                <td>
                                    <?php echo $rubro[tipr_descripcion]?>
                                </td>
                                <td>
                                    <?php echo $rubro[tiprc_descripcion]?>
                                </td>
                                <td>
                                    <?php echo $rubro[tiprubcl_descripcion]?>
                                </td>
                                <td>
                                    <a href="#" onclick="$.ajax({
                                                            type: 'POST',
                                                            url: 'accion.php',
                                                            data: {
                                                                codigo: <?php echo $rubro[tiprc_codigo];?>,
                                                                dmn: <?php echo $idMenut?>,
                                                                act: 10,
                                                                actd: 12,
                                                                ver:2
                                                            },
                                                            success: function(html) {
                                                                actualizar();
                                                                $('#tr_<?php echo $rubro[tiprubcl_codigo]?>').remove();
                                                            }
        										          });">
                                        <i class="fa fa-minus-square"></i>
                                    </a>
                                </td>
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
    $(document).ready(function () {
        $('#rubro_clase').DataTable({
            pageLength: 10
            , responsive: true
        });
    });

    function actualizar() {
        $.ajax({
            type: 'POST'
            , url: 'accion.php'
            , data: {
                dmn: <?php echo $idMenut?>
                , act: 10
                , actd: 8
                , ver: 2
            }
            , ajaxSend: $('#rubro_clase').html(cargando)
            , success: function (html) {
                $('#rubro_clase').DataTable({
                    destroy: true
                });
                $('#rubro_clase').html(html);
            }
        });
    }
</script>