<?php
    include("../includes/layout/head.php");
    include("../includes/layout/sidebar.php");
    include("../includes/layout/header.php");
    include("../includes/layout/cuerpo.php");
    include("../includes/layout/foot.php");
?>
<script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.warning('Planifica tu produccion', 'Bienvenido a Prolium');

            }, 1300);
        });
</script>