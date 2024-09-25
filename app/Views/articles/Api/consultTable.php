<?php

use function Helpers\generateUrl;
?>
<div class="container d-flex">
    <div class="col-md-6">

        <button data-url="<?= generateUrl("Api","Api","consultGridArticles",['order'=>'3'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/piezas.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Api","Api","consultGridArticles",['order'=>'4'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/grid-alt.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Api","Api","consultGridArticles",['order'=>'6'],"ajax")?>"
            class="btn-grid btn btn-light">
            <img src="img/secciones.png" alt="" srcset="">
        </button>
        <button data-url="<?= generateUrl("Api","Api","consultGridArticles",['order'=>'table'],"ajax")?>"
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

<div class="container table-responsive">
    <div class="container" id="contArticles">
    <style>
    table.DataTable {
        font-size: 14px; /* Ajusta el tamaño de fuente a tu preferencia */
    }
</style>

<table id="myTable" class="DataTable text-center table slide-in-top table-hover">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th class="">Descripción</th>
            <th class="text-nowrap">Cantidad en stock</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $art): ?>
            <tr>
                <td><img class="viewArticle" value="<?= $art->id ?>" src="<?= $art->images[0]->src ?>" alt="..." height="50" data-url="<?= Helpers\generateUrl("Api", "Api", "viewArticleDesc", [], "ajax") ?>" data-value="<?= $art->id ?>"></td>
                <td class="truncate text-nowrap"><?= $art->sku ?></td>
                <td class="truncate text-nowrap"><?= $art->name ?></td>
                <td><?= $art->short_description ?></td>
                <td><?= $art->stock_quantity ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
</div>