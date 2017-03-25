<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Instituciones productivas a nivel nacional</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;">
                <select class="form-control" id="selinst" onchange="if($('#selinst').val()=='0'){ actr =2;} else {actr =3;}$.ajax({
                type: 'POST'
                , url: 'accion.php'
                , data: {
                     dmn: <?php echo $idMenut?>
                    , ver: 2
                    , act: actr
                    , institu: $('#selinst').val()
                }
                , ajaxSend: $('#mapa-data').html(cargando)
                , success: function (html) {
                    $('#mapa-data').html(html);
                }
            });">
                    <option value="0">Todas</option>
                <?php
                    combos::CombosSelect("1", "$inst", "inst_codigo, inst_nombre", "institucion", "inst_codigo", "inst_nombre", "1=1");
                ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Posicionamiento geografico nacional</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                </div>
            </div>
            <div class="ibox-content" style="display: block;" id="mapa-data">
            </div>
        </div>
    </div>
</div>
