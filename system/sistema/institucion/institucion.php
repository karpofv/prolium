<?php
    $codigo=$_POST[codigo];
    $rif=$_POST[rif];
    $inst=$_POST[inst];
    $resp=$_POST[resp];
    $seltip=$_POST[seltip];
    $selpar=$_POST[selpar];
    $direc=$_POST[direc];
    $lat=$_POST[lat];
    $long=$_POST[long];
    $editar=$_POST[editar];
    $eliminar=$_POST[eliminar];
    if($editar==""){
        $editar==0;
    } else {
        $editar==1;
    }
    /*INSERTAR*/
    if($editar==0 and $eliminar=="" and $inst!=""){
        $inserte = paraTodos::arrayInserte("inst_rif,inst_nombre,inst_responsable,inst_tipo,inst_parroquia,inst_direccion, inst_latitud, inst_longitud", "institucion", "'$rif', '$inst', '$resp', '$seltip', '$selpar', '$direc', '$lat', '$long'");
        $rif=null;
        $inst=null;
        $resp=null;
        $seltip=null;
        $selpar=null;
        $direc=null;
        $lat=null;
        $long=null;
    }
    /*EDITAR*/
    if($editar==1 and $inst!=""){
        $update = paraTodos::arrayUpdate("inst_rif='$rif',inst_nombre='$inst',inst_responsable='$resp',inst_tipo='$seltip',inst_parroquia='$selpar', inst_direccion='$direc',inst_latitud='$lat',inst_longitud='$long'", "institucion", "inst_codigo=$codigo");
        $codigo=null;
        $rif=null;
        $inst=null;
        $resp=null;
        $seltip=null;
        $selpar=null;
        $direc=null;
        $lat=null;
        $long=null;
    }
    /*MOSTRAR*/
    if($editar==1 and $inst==""){
        $consulinst = paraTodos::arrayConsulta("*", "institucion", "inst_codigo=$codigo");
        foreach($consulinst as $insti){
            $rif=$insti[inst_rif];
            $inst=$insti[inst_nombre];
            $resp=$insti[inst_responsable];
            $seltip=$insti[inst_tipo];
            $selpar=$insti[inst_parroquia];
            $direc=$insti[inst_direccion];
            $lat=$insti[inst_latitud];
            $long=$insti[inst_longitud];
            $consulpar = paraTodos::arrayConsulta("est_codigo, mun_codigo", "tools_estados e, tools_municipios m, tools_parroquia p", "m.mun_estcodigo=e.est_codigo and p.par_muncodigo=m.mun_codigo and p.par_codigo=$selpar");
            foreach($consulpar as $par){
                $selestado = $par[est_codigo];
                $selmun = $par[mun_codigo];
            }
        }
    }
    /*ELIMINAR*/
    if($eliminar==1){
        $delete = paraTodos::arrayDelete("inst_codigo=$codigo", "institucion");
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
                <?php
                    if($editar==""){
                        $editar=0;
                    } else {
                        $editar=1;
                    }
                ?>
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
                                                                            long: $('#longitud').val(),
                                                                            lat: $('#latitud').val(),
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
                                    <input type="text" class="form-control" id="rif" value="<?php echo $rif;?>">
                                </div>                                
                                <div class="col-md-9">
                                    <label class="control-label">Nombre de la institución o razon social</label>
                                    <input type="text" class="form-control" id="txtinst" value="<?php echo $inst;?>">
                                    <input type="number" class="collapse" id="codigo" value="<?php echo $codigo;?>">
                                </div>
                                <div class="col-md-5">
                                    <label class="control-label">Responsable</label>
                                    <input type="text" class="form-control" id="resp" value="<?php echo $resp;?>">
                                </div>
                                <div class="col-md-7">
                                    <label class="control-label">Tipo de institución</label>
                                    <select class="form-control" id="seltipo">
                                        <?php
                                            combos::CombosSelect("1", "$seltip", "tipin_codigo, tipin_descripcion", "tipo_institucion", "tipin_codigo", "tipin_descripcion", "1=1");
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
                                        <?php
                                            combos::CombosSelect("1", "$selmun", "mun_codigo, mun_descripcion", "tools_municipios", "mun_codigo", "mun_descripcion", "mun_estcodigo=$selestado");
                                        ?>
                                    </select>
                                </div>                                    
                                <div class="col-md-4">
                                    <label class="control-label">Parroquia</label>
                                    <select class="form-control" id="selpar">
                                        <option value="0">Seleccione una parroquia</option>
                                        <?php
                                            combos::CombosSelect("1", "$selpar", "par_codigo, par_descripcion", "tools_parroquia", "par_codigo", "par_descripcion", "par_muncodigo=$selmun");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label">Dirección</label>
                                    <textarea class="form-control" id="txtdirec"><?php echo $direc; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <h4>Geo-localización</h4>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label class="control-label">Latitud</label>
                            <input type="text" class="form-control" id="latitud" value="<?php echo $lat;?>">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Longitud</label>
                            <input type="text" class="form-control" id="longitud" value="<?php echo $long;?>">
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
                            $consulinst = paraTodos::arrayConsulta("i.*,est_descripcion, mun_descripcion, p.par_descripcion", "tools_estados e, tools_municipios m, tools_parroquia p, institucion i", "m.mun_estcodigo=e.est_codigo and p.par_muncodigo=m.mun_codigo and p.par_codigo=i.inst_parroquia");
                            foreach($consulinst as $insti){
                        ?>
                        <tr>
                            <td><?php echo $insti[inst_rif]?></td>
                            <td><?php echo $insti[inst_nombre]?></td>
                            <td><?php echo $insti[inst_responsable]?></td>
                            <td><?php echo $insti[est_descripcion]?></td>
                            <td><?php echo $insti[mun_descripcion]?></td>
                            <td><?php echo $insti[par_descripcion]?></td>
                            <td><?php echo $insti[inst_direccion]?></td>
                            <td><a href="#" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: <?php echo $insti[inst_codigo]?>,
                                                                            dmn: <?php echo $idMenut?>,
                                                                            editar: '1',
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });">Editar</a></td>
                            <td><a href="#" onclick="$.ajax({
                                                                        type: 'POST',
                                                                        url: 'accion.php',
                                                                        data: {
                                                                            codigo: <?php echo $insti[inst_codigo]?>,
                                                                            dmn: <?php echo $idMenut?>,
                                                                            eliminar: '1',
                                                                            ver:2
                                                                        },
                                                                        ajaxSend: $('#page-content').html(cargando),
                                                                        success: function(html) { $('#page-content').html(html); }
        										                      });"><i class="fa fa-minus-circle"></i></a></td>
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
