<?php
//-------------------------------------------------------
// GENERAL********************************************
//-------------------------------------------------------
$opcion = $_POST[actd];
if ($opcion == '1') {
    $valida = paraTodos::arrayConsultanum("*", "zona", "zon_descripcion='$_POST[zona]'");
    if($valida==0){
        $inserte = paraTodos::arrayInserte("zon_descripcion", "zona", "'$_POST[zona]'");
        if($inserte){
            paraTodos::notifica("Zona registrada exitosamente", "success");
        }
        combos::CombosSelect("1", "0", "zon_codigo, zon_descripcion", "zona", "zon_codigo", "zon_descripcion", "1=1");
    } else {
        paraTodos::notifica("Ya existe una zona bajo esta descripcion", "warning");
    }
}
if ($opcion == '2') {
    $delete = paraTodos::arrayDelete("zon_codigo=$_POST[codigo]","zona");
    if($delete){
        combos::CombosSelect("1", "0", "zon_codigo, zon_descripcion", "zona", "zon_codigo", "zon_descripcion", "1=1");
        paraTodos::notifica("Zona eliminada exitosamente", "success");
    }
}
if ($opcion == '3') {
    $inserte = paraTodos::arrayInserte("zond_zoncodigo, zond_est_codigo", "zona_estado", "$_POST[zona],$_POST[estado] ");
    if($inserte){
        paraTodos::notifica("Estado asigando exitosamente", "success");
    }
    combos::CombosSelect("1", "0", "est_codigo, est_descripcion", "tools_estados e", "est_codigo", "est_descripcion", " e.est_codigo not in (select zond_est_codigo from zona_estado ze)");
}
if ($opcion == '4') {
?>
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
                                                                            dmn: <?php echo dmn?>,
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
<?php
}
if ($opcion == '5') {
    $delete = paraTodos::arrayDelete("zond_codigo=$_POST[codigo]","zona_estado");
    if($delete){
        combos::CombosSelect("1", "0", "est_codigo, est_descripcion", "tools_estados e", "est_codigo", "est_descripcion", " e.est_codigo not in (select zond_est_codigo from zona_estado ze)");
        paraTodos::notifica("Estado eliminado exitosamente", "success");
    }
}
?>
