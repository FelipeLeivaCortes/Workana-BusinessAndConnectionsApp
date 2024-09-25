<div class="container table-responsive">
    <table id="myTable"
        class="DataTable truncate text-center table align-middle slide-in-top table-hover table-responsive">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Peso</th>
                <th>Color</th>
                <th class="text-nowrap">Cantidad Articulo</th>
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
            <?php foreach ($articles as $art) { ?>
            <tr>
                <td><img src="<?= $art['ar_img_url'] ?>" class="card-img-top viewArticle" alt="..." height="100"
                        data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>"
                        data-value="<?= $ar['ar_id'] ?>"></td>
                <td><?= $art['ar_name']?></td>
                <td class="truncate"><?= $art['ar_desc']?></td>
                <td><?= $art['ar_measurement_value']?>kg</td>
                <?php foreach ($art['color'] as $color): ?>
                <td><?= $color['color_name']?></td>
                <?php endforeach; ?>
                <td>
                    <div class="d-flex align-items-center justify-content-center">
                        <input type="number" name="quantity" class="form form-control" id="" min="1"
                            style="width:50%;"><button
                            data-url="<?= Helpers\generateUrl("Quote","Quote","AddArticlesAjax",[],"ajax");?>"
                            value="<?= $art['ar_id']?>" id="addArticles" class="btn btn-outline-primary"><i
                                class="fa-regular fa-square-plus"></i></button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>