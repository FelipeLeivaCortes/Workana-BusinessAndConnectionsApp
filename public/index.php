<?php
    include_once '../config/helpers.php';
    include_once '../config/Auth.php';
    include_once '../config/global.php';

    // Evitar caché en el navegador
    header("Cache-Control: private, no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Evitar caché en proxies compartidos
    header("Cache-Control: no-store, no-cache, must-revalidate, proxy-revalidate");

    // Evitar caché en versiones antiguas de Internet Explorer
    header("Cache-Control: post-check=0, pre-check=0", false);

    // Cabecera de Vary
    header("Vary: *");

    // Cabecera de Last-Modified
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    // Cabecera de ETag
    header("ETag: " . md5(rand()));

    include_once '../app/Views/partials/header.php';
?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include_once '../app/Views/partials/sidebar.php'; ?>
            <div class="layout-page">
                <?php include_once '../app/Views/partials/navbar.php';?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php
                        if (isset($_GET['module'])) {
                            Helpers\resolve();
                        } else {
                           
                            include_once '../app/Views/partials/home.php';
                        }
                        ?>
                    </div>

                    <?php 
                    include_once '../app/Views/partials/footer.php';
                    include_once '../app/Views/partials/modal_default.php'; 
                    include_once '../app/Views/partials/modalFullScreen.php';
                    include_once '../app/Views/partials/modal.php';                    
                    include_once '../app/Views/partials/modalHigh.php';
                    include_once '../app/Views/partials/modalStatic.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>