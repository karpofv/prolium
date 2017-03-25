<?php
//-------------------------------------------------------
// GENERAL********************************************
//-------------------------------------------------------
$opcion = $_POST[actd];
if ($opcion == '1') {
    echo "<option value='0'>Seleccione un municipio</option>";
    combos::CombosSelect("1", "0", "mun_codigo, mun_descripcion", "tools_municipios", "mun_codigo", "mun_descripcion", "mun_estcodigo=$_POST[codigo]");
}
if ($opcion == '2') {
    combos::CombosSelect("1", "0", "par_codigo, par_descripcion", "tools_parroquia", "par_codigo", "par_descripcion", "par_muncodigo=$_POST[codigo]");
}
if ($opcion == '3') {
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
if ($opcion == '4') {
    $delete = paraTodos::arrayDelete("zon_codigo=$_POST[codigo]","zona");
    if($delete){
        combos::CombosSelect("1", "0", "zon_codigo, zon_descripcion", "zona", "zon_codigo", "zon_descripcion", "1=1");
        paraTodos::notifica("Zona eliminada exitosamente", "success");
    }
}
?>
