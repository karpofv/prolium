<?php
//-------------------------------------------------------
// GENERAL********************************************
//-------------------------------------------------------
$opcion = $_POST[actd];
if ($opcion == '1') {
    $valida = paraTodos::arrayConsultanum("*", "rubros", "rub_descripcion='$_POST[rubro]'");
    if($valida==0){
        $inserte = paraTodos::arrayInserte("rub_descripcion", "rubros", "'$_POST[rubro]'");
        if($inserte){
            paraTodos::notifica("Rubro registrado exitosamente", "success");
        }
        combos::CombosSelect("1", "0", "rub_codigo, rub_descripcion", "rubros", "rub_codigo", "rub_descripcion", "1=1 order by rub_descripcion");
    } else {
        paraTodos::notifica("Ya existe un rubro bajo esta descripcion", "warning");
    }
}
if ($opcion == '2') {
    $delete = paraTodos::arrayDelete("rub_codigo=$_POST[codigo]","rubros");
    if($delete){
        combos::CombosSelect("1", "0", "rub_codigo, rub_descripcion", "rubros", "rub_codigo", "rub_descripcion", "1=1 order by rub_descripcion");
        paraTodos::notifica("Rubro eliminado exitosamente", "success");
    }
}
if ($opcion == '3') {
    $valida = paraTodos::arrayConsultanum("*", "tipo_rubro", "tipr_descripcion='$_POST[tiprub]' and tipr_rubcodigo=$_POST[rubro]");
    if($valida==0){
        $inserte = paraTodos::arrayInserte("tipr_rubcodigo, tipr_descripcion", "tipo_rubro", "$_POST[rubro],'$_POST[tiprub]'");
        if($inserte){
            paraTodos::notifica("Tipo de rubro asignado exitosamente", "success");
        }
    } else {
        paraTodos::notifica("Ya existe un tipo de rubro bajo esta descripcion", "warning");
    }
}
if ($opcion == '4') {
?>
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
                                                                            $('#tr_<?php echo $rubro[tipr_codigo]?>').remove();
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
    $delete = paraTodos::arrayDelete("tipr_codigo=$_POST[codigo]","tipo_rubro");
    if($delete){
        paraTodos::notifica("Estado eliminado exitosamente", "success");
    }
}
?>
