<?php
use function Helpers\generateUrl;

if (isset($_SESSION['welcome']) && $_SESSION['welcome'] == false) {
    echo "
    <div class='container text-focus-in'>
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Bienvenido, " . $_SESSION['nameUser'] . "!</strong> Gracias por ingresar al sistema.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Cerrar'></button>
        </div>
    </div>";
    $_SESSION['welcome'] = true; // Establece la variable de sesión de "flag" en "true"
}

if ($_SESSION['StatusUser'] == '2' AND $_SESSION['RolUser'] == '2') {
    echo "
    <div class='container text-focus-in'>
        <div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Hola, usuario! para poder activar los modulos y terminar el registro de tu empresa<br>
            por favor rellena el formulario de registro,
            que se encuentra en el panel izquierdo o presiona <a href='".generateUrl("Company","Company","RegisterUpdateView")."'>Aquí</a></strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Cerrar'></button>
        </div>
    </div>";
}

// HERE THE SESSION VARIABLE IS PRINTED SO THAT WE CAN MODIFY THE GRAPHICS WE ARE GOING TO USE FROM THE HOME JS
echo '<script>var RolUser = ' . json_encode($_SESSION['RolUser']) . ';</script>';

// var_dump($_SESSION);
?>
<div class="container">
    <h1 class="tracking-in-expand">INFORMACIÓN GENERAL</h1>
    <div class="timeline d-flex text-center">
        <div class="circle-container mx-3">
            <a style="text-decoration:none;" href="<?= Helpers\generateUrl("Access","Access","HomeView");?>">
                <div class="circle scale-in-hor-center">
                    <i id="home" class="fa-sharp fa-solid fa-house-chimney"></i>
                </div>
            </a>
            <span><b>Inicio</b></span>
        </div>
        <?php if ($_SESSION['RolUser'] == '3'): ?>
        <div class="circle-container mx-3">
            <div class="circle scale-in-hor-center"
                data-url="<?= generateUrl("Company","Company","ViewProfilesUsers",[],"ajax");?>" id="contIconUsers">
                <i title="Perfiles de usuarios" id="users" class="fa-solid fa-users"></i>
            </div>
            <span><b>Usuarios</b></span>
        </div>
        <?php endif; ?>
        <?php if ($_SESSION['StatusUser'] == '1' AND $_SESSION['RolUser'] == '3' OR $_SESSION['RolUser'] == '4'): ?>

        <div class="circle-container mx-3">
            <div id="contIconAddress" class="circle scale-in-hor-center"
                data-url="<?= generateUrl("Company","Company","ViewAddressCompany",[],"ajax");?>">
                <i title="Direcciones de la empresa" id="address" class="fa-solid fa-address-book"></i>
            </div>
            <span><b>Direcciones</b></span>
        </div>
        <?php endif; ?>

    </div>
</div>
<!-- Container for ajax -->
<div class="container card" id="homecont">

    <!-- VARS GRAPHICS -->
    <?php echo "<input type='hidden' id='GraphicsOrders' value='".count($_SESSION['GraphicsOrders'])."'>";?>
    <?php echo "<input type='hidden' id='GraphicsQuotes' value='".count($_SESSION['GraphicsQuotes'])."'>";?>

    <div class="container">
        <div class="col-md-4">
            <h3 class="tracking-in-expand">
                Empresa
            </h3>
            <div class="input-group mb-3">
                <h4 class="text-focus-in"> <?= $_SESSION['CompanyName'];?></h4>
            </div>


        </div>
        <!-- GRAPHICS -->
        <div class="col-md-12 row">
            <div id="myChartContainer">
                <canvas id="myChart"></canvas>
            </div>
            <div id="myPieChartContainer">
                <canvas id="myPieChart"></canvas>
            </div> 
        </div>
        <div class="col-md-12 row">
            <div id="myChartContainer">
                <canvas id="myChart2"></canvas>
            </div>
            <div id="myPieChartContainer">
                <canvas id="myPieChart2"></canvas>
            </div> 
        </div>
    </div>


</div>
<?php

// var_dump($_SESSION);
?>