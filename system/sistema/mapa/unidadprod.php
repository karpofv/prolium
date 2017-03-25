<?php
    $consulinst = paraTodos::arrayConsulta("inst_codigo,inst_latitud, inst_longitud, inst_nombre, inst_direccion", "institucion", "inst_codigo=$_POST[institu]");
    foreach($consulinst as $inst){
        $latitud =$inst[inst_latitud];
        $longitud =$inst[inst_longitud];
    }
?>
<div class="container" id="map"></div>
<style type="text/css">
    #map {
        height: 600px;
        width: 100%;
    }
</style>

<script type="text/javascript">
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: <?php echo $latitud;?>
                , lng: <?php echo $longitud;?>
            }
            , zoom: 8
        });
        <?php
            $consulinst = paraTodos::arrayConsulta("inst_codigo,inst_latitud, inst_longitud, inst_nombre, inst_direccion", "institucion", "1=1");
            foreach($consulinst as $inst){
        ?>
            var marker<?php echo $inst[inst_codigo];?> = new google.maps.Marker({
                animation: google.maps.Animation.DROP
                , position: {
                    lat: <?php echo $inst[inst_latitud];?>
                    , lng: <?php echo $inst[inst_longitud];?>
                }
                , map: map
                , title: '<?php echo $inst[inst_nombre];?>'
            });
            /*EVENTO CLICK*/
            marker<?php echo $inst[inst_codigo];?>.addListener('click', function () {
                $.ajax({
                    type: 'POST'
                    , url: 'accion.php'
                    , data: {
                         dmn: <?php echo $idMenut?>
                        , ver: 2
                    }
                    , ajaxSend: $('#page-content').html(cargando)
                    , success: function (html) {
                        $('#page-content').html(html);
                    }
                });
            });
            /* ESTO PERMITE COLOCAR LA VENTA EMERGENTE CON EL CONTENIDO*/
            var contentString<?php echo $inst[inst_codigo];?> = '<div id="content"><?php echo $inst[inst_direccion];?></div>';
            var infowindow<?php echo $inst[inst_codigo];?> = new google.maps.InfoWindow({
                content: contentString<?php echo $inst[inst_codigo];?>
            });
            marker<?php echo $inst[inst_codigo];?>.addListener('mouseover', function() {
                infowindow<?php echo $inst[inst_codigo];?>.open(map, marker<?php echo $inst[inst_codigo];?>);
            });
        <?php
            }
        ?>
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCi3NkVuJEf23esbMjXXxu-B0fGaUfh4qM&callback=initMap">
</script>
