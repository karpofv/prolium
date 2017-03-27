<div class="modal" id="ventanaModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cerrarmodal()"> <span aria-hidden="true">×</span> <span class="sr-only">Close</span> </button>
                <h4 class="modal-title">Tipos de rubros</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover " id="selecttiprub">
                            <thead>
                                <tr>
                                    <th>Rubro</th>
                                    <th>Tipo de rubro</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody id="body_inst">
                                <?php
                                $consulrubro = paraTodos::arrayConsulta("*", "rubros r, tipo_rubro tp", "tp.tipr_rubcodigo=r.rub_codigo order by rub_descripcion");
                                foreach($consulrubro as $rubro){
                            ?>
                                    <tr id="tr_<?php echo $rubro[tipr_codigo]?>">
                                        <td>
                                            <?php echo $rubro[rub_descripcion]?>
                                        </td>
                                        <td>
                                            <?php echo $rubro[tipr_descripcion]?>
                                        </td>
                                        <td>
                                            <a href="#" onclick="
                                                                 $('#lblrubro').html('<?php echo $rubro[rub_descripcion]?>');
                                                                 $('#lbltprubro').html('<?php echo $rubro[tipr_descripcion]?>');
                                                                 $('#codigo').val('<?php echo $rubro[tipr_codigo]?>');
                                                                 $('#datossave').removeClass('collapse');
                                                                 cerrarmodal();
                                                                 $.ajax({
                                                                    type: 'POST',
                                                                    url: 'accion.php',
                                                                    data: {
                                                                        codigo:<?php echo $rubro[tipr_codigo]?>,
                                                                        dmn: <?php echo $idMenut?>,
                                                                        act: 10,
                                                                        actd: 10,
                                                                        ver:2
                                                                    },
                                                                    ajaxSend: $('#selclase').html(cargando),
                                                                    success: function(html) {
                                                                        actualizar();
                                                                        $('#selclase').html(html);
                                                                    }
                                                                });"> 
                                                <i class="fa fa-plus-circle"></i>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal" onclick="cerrarmodal()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#selecttiprub').DataTable({
            pageLength: 10
            , responsive: true
        });
    });
</script>