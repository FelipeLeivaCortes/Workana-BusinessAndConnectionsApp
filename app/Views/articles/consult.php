<?php

use function Helpers\generateUrl;
?>




    <?php 
$count = 0; 
foreach ($articles as $art) { 
    if ($count % 2 == 0) { 
        echo '<div class="row mt-3">'; // Crea una nueva fila
    }
?>
   <div class="col-md-6 cardsDiv">
        <div class="card">
            <img src="<?= $art['ar_img_url']?>" data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>" data-value="<?= $art['ar_id'] ?>" class="card-img-top img-fluid rounded viewArticle"  style="height: 400px ; object-fit: cover;" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $art['ar_name']?></h5>
                <!-- Aplica la función substr para truncar la descripción -->
                <p class="card-text"><b>Descripcióna: </b><?= substr($art['ar_desc'], 0, 100) . '...' ?></p>
                <p class="card-text"><b>Unidad de medida: </b><?= $art['ar_measurement_value']?> <?php foreach ($art['meauserement'] as $m) {
                    echo $m['mt_meas'];
                ?></p>
                <?php  } ?>
                <?php foreach ($art['color'] as $color): ?>
                <p class="card-text"><b>Color: </b><?= $color['color_name']?></p>
                <?php endforeach; ?>
                <?php foreach ($art['price'] as $price): ?>
                <p class="card-text"><b>Precio: </b><?= $price['p_value'] ?></p>
                <?php endforeach; ?>
                <?php if (!empty($art['stock'])): ?>
                <?php foreach ($art['stock'] as $stock): ?>
                <p class="card-text"><b>Cantidad en stock: </b><?= $stock['stock_Quantity']?></p>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="card-text"><b>Cantidad en stock: </b>Sin existencias</p>
                <?php endif; ?>
                <button id="pdf-btn" data-pdf-url="<?= $art['ar_data_url']?>" class="btn btn-outline-primary">Ficha
                    técnica</button>
            </div>
        </div>
    </div>
    <?php 
    $count++;
    if ($count % 2 == 0) {
        echo '</div>';
    }
} 


// Si el número de artículos no es par, cerrar la última fila
if ($count % 2 != 0) { 
    echo '</div>';
}
?>
