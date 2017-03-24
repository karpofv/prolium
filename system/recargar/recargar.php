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
?>
