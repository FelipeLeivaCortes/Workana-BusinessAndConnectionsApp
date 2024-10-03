<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex justify-content-center">
                <button
                    data-url="<?= Helpers\generateUrl("Articles","Articles","consultGridArticles",['order'=>'3'],"ajax")?>"
                    class="btn-grid btn btn-light ">
                    <img src="img/piezas.png" alt="" srcset="">
                </button>
                <button
                    data-url="<?=  Helpers\generateUrl("Articles","Articles","consultGridArticles",['order'=>'4'],"ajax")?>"
                    class="btn-grid btn btn-light ">
                    <img src="img/grid-alt.png" alt="" srcset="">
                </button>
                <button
                    data-url="<?= Helpers\generateUrl("Articles","Articles","consultGridArticles",['order'=>'6'],"ajax")?>"
                    class="btn-grid btn btn-light ">
                    <img src="img/secciones.png" alt="" srcset="">
                </button>
                <button
                    data-url="<?= Helpers\generateUrl("Articles","Articles","consultGridArticles",['order'=>'table'],"ajax")?>"
                    class="btn-grid btn btn-light ">
                    <img src="img/table.png" alt="" srcset="">
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar"
                    aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container table-responsive">
    <div class="container" id="contArticles">
        <table id="myTable"
            class="DataTable truncate table-sm text-center table align-middle slide-in-top table-hover ">
            <thead>
                <tr>
                    <th class="text-nowrap">Imagen</th>
                    <th class="text-nowrap">Nombre</th>
                    <th class=" padding-left-right">Descripción</th>
                    <th class=" text-nowrap">Unidad de medida</th>
                    <th class=" text-nowrap">Cantidad en stock</th>
                    <th class=" text-nowrap">Ficha tecnica</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($articles as $art) { ?>
                        <tr>
                            <td><img class='viewArticle' value="<?= $art['ar_id']?>" src="<?= $art['ar_img_url']?>" alt="..."
                                    height="100"
                                    data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>"
                                    data-value="<?= $art['ar_id'] ?>"></td>
                            <td><?= $art['ar_name']?></td>
                            <td class="truncate"><?= $art['ar_desc']?></td>
                            <td><?= $art['ar_measurement_value']?>
                                <?php foreach ($art['meauserement'] as $m) {
                                echo $m['mt_meas'];
                                ?>
                                <?php  } ?>
                            </td>
                            <?php if (!empty($art['stock'])): ?>
                            <?php foreach ($art['stock'] as $stock): ?>
                            <td><?= $stock['stock_Quantity']?></td>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <td>Sin existencias</td>
                            <?php endif; ?>
                            <td>
                                <div class="btn-group">
                                    <button id="pdf-btn" data-pdf-url="<?= $art['ar_data_url']?>" class="btn btn-outline-light"
                                        style="border:1px solid #ff0000;"><i class="fa-regular fa-file-pdf fa-beat"
                                            style="color: #ff0000;"></i></button>
                                </div>
                            </td>
                        </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>