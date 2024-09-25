<?php

use function Helpers\generateUrl;
?>

<div class="container d-flex">
    <div class="col-md-6">

        <button data-url="<?= generateUrl("Quote","Quote","consultGridArticles",['order'=>'3'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/piezas.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Quote","Quote","consultGridArticles",['order'=>'4'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/grid-alt.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Quote","Quote","consultGridArticles",['order'=>'6'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/secciones.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Quote","Quote","consultGridArticles",['order'=>'table'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/table.png" alt="" srcset="">
        </button>
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar"
            aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

</div>

<div class="container" id="contArticles">
    <?php 
    $count = 0; 
    foreach ($articles as $art) { 
      if ($count % 2 == 0) { 
        echo '<div class="row mt-3">'; //crea una nueva fila
      }
    ?>
    <div class="col-md-6 cardsDiv ">
        <div class="card">
            <img src="<?= $art['ar_img_url']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $art['ar_name']?></h5>
                <p class="card-text"><b>Descripción: </b><?= $art['ar_desc']?></p>
                <p class="card-text"><b>Peso: </b><?= $art['ar_measurement_value']?>kg</p>
                <?php foreach ($art['color'] as $color): ?>
                <p class="card-text"><b>Color: </b><?= $color['color_name']?></p>
                <?php endforeach; ?>
                <p><b>Cantidad:</b>
                    <input min="1" type="number" class="mt-2 mb-2 quantityinput form form-control" name="quantity" id="">
                    <button data-url="<?= Helpers\generateUrl("Quote","Quote","AddArticlesAjax",[],"ajax");?>"
                                        value="<?= $art['ar_id']?>" id="addArticles" class="btn btn-outline-primary">Añadir
                                        articulo</button>
                </p>
            </div>
        </div>
    </div>
    <?php 
      $count++; // incrementar el contador 
      if ($count % 2 == 0) { // se cierra cuando llega a 3
        echo '</div>';
      }
    } 
    // si el número de artículos no es par, cerrar la última fila
    if ($count % 2 != 0) { 
      echo '</div>';
    }
    ?>
</div>