<?php
    $codigo=$_POST[codigo];
    $rif=$_POST[rif];
    $inst=$_POST[inst];
    $resp=$_POST[resp];
    $seltip=$_POST[seltip];
    $selpar=$_POST[selpar];
    $direc=$_POST[direc];
    $editar=$_POST[editar];
    $eliminar=$_POST[eliminar];
    if($editar==""){
        $editar==0;
    } else {
        $editar==1;
    }
    /*MOSTRAR*/
    if($editar==1 and $inst==""){
        $consulinst = paraTodos::arrayConsulta("*", "institucion", "int_codigo=$codigo");
        foreach($consulinst as $inst){
            $rif=$inst[inst_rif];
            $inst=$inst[inst_nombre];
            $resp=$inst[inst_responsable];
            $seltip=$inst[inst_tipo];
            $selpar=$inst[inst_parroquia];
            $direc=$inst[inst_direccion];
        }        
    }
    /*INSERTAR*/
    if($editar==0 and $eliminar=="" and $inst!=""){
        $inserte = paraTodos::arrayInserte("inst_rif,inst_nombre,inst_responsable,inst_tipo,inst_parroquia,inst_direccion", "institucion", "'$rif', '$inst', '$resp', '$seltip', '$selpar', '$direc'");
        $rif=null;
        $inst=null;
        $resp=null;
        $seltip=null;
        $selpar=null;
        $direc=null;
    }
    /*EDITAR*/
    if($editar==1 and $inst!=""){
        $update = paraTodos::arrayUpdate("inst_rif='$rif',inst_nombre='$inst',inst_responsable='$resp',inst_tipo='$seltip',inst_parroquia='$selpar',inst_direccion= '$direc'", "institucion", "int_codigo=$codigo");
        $rif=null;
        $inst=null;
        $resp=null;
        $seltip=null;
        $selpar=null;
        $direc=null;        
    }
    /*ELIMINAR*/
    if($eliminar==1){
        $delete = paraTodos::arrayDelete("int_codigo=$codigo", "institucion");
    }
    
?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edición y registro de instituciones</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <form method="post" class="form-horizontal" action="" onsubmit="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: $('#codigo').val(), 
                                                                            rif: $('#rif').val(), 
                                                                            inst: $('#txtinst').val(), 
                                                                            resp: $('#resp').val(), 
                                                                            seltip: $('#seltipo').val(), 
                                                                            selpar: $('#selpar').val(), 
                                                                            direc: $('#txtdirec').val(), 
                                                                            dmn: <?php echo $idMenut?>,
                                                                            editar: '<?php echo $editar?>',
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),                                                    
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Rif</label>
                                    <input type="text" class="form-control" id="rif">
                                </div>                                
                                <div class="col-md-9">
                                    <label class="control-label">Nombre de la institución o razon social</label>
                                    <input type="text" class="form-control" id="txtinst">
                                    <input type="number" class="collapse" id="codigo">
                                </div>
                                <div class="col-md-5">
                                    <label class="control-label">Responsable</label>
                                    <input type="text" class="form-control" id="resp">
                                </div>
                                <div class="col-md-7">
                                    <label class="control-label">Tipo de institución</label>
                                    <select class="form-control" id="seltipo">
                                        <?php
                                            combos::CombosSelect("1", "$seltipo", "tipin_codigo, tipin_descripcion", "tipo_institucion", "tipin_codigo", "tipin_descripcion", "1=1");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Estado</label>
                                    <select class="form-control" id="selestado" onchange="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: $('#selestado').val(), 
                                                                            dmn: 2,
                                                                            ver: 1,
                                                                            actd: 1
                                                                        },
                                                                        ajaxSend: $('#selmun').html(cargando),                                                    
                                                                        success: function(html) { $('#selmun').html(html); }
        										                      });">
                                        <option value="0">Seleccione un estado</option>
                                        <?php
                                            combos::CombosSelect("1", "$selestado", "est_codigo, est_descripcion", "tools_estados", "est_codigo", "est_descripcion", "1=1");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Municipio</label>
                                    <select class="form-control" id="selmun" onchange="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: $('#selmun').val(), 
                                                                            dmn: 2,
                                                                            ver: 1,
                                                                            actd: 2
                                                                        },
                                                                        ajaxSend: $('#selpar').html(cargando),                                                    
                                                                        success: function(html) { $('#selpar').html(html); }
        										                      });">
                                        <option value="0">Seleccione un municipio</option>                                        
                                    </select>
                                </div>                                    
                                <div class="col-md-4">
                                    <label class="control-label">Parroquia</label>
                                    <select class="form-control" id="selpar">
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label">Dirección</label>
                                    <textarea class="form-control" id="txtdirec"></textarea>
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
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Instituciones o establecimientos registrados</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <table class="table table-striped table-bordered table-hover " id="instituciones">
                    <thead>
                        <tr>
                            <th>Rif</th>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Dirección</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $consulinst = paraTodos::arrayConsulta("*", "institucion", "1=1");
                            foreach($consulinst as $inst){
                        ?>
                        <tr>
                            <td><?php echo $inst[inst_rif]?></td>
                            <td><?php echo $inst[inst_nombre]?></td>
                            <td><?php echo $inst[inst_responsable]?></td>
                            <td><?php echo $inst[inst_tipo]?></td>
                            <td><?php echo $inst[inst_parroquia]?></td>
                            <td><?php echo $inst[inst_direccion]?></td>
                            <td><a href="#" onclick=""><i class=""></i></a></td>
                            <td><a href="#" onclick=""><i class=""></i></a></td>
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