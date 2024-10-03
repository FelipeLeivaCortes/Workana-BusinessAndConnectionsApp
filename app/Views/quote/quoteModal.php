
<style>
    .table-cell {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .quantityinput {
        flex-grow: 1;
        margin-right: 10px; /* Espacio entre el input y el botón */
        min-width: 80px; /* Ancho mínimo para el input */
    }
</style>

<div class="table-responsive">
    <table id="tableModalCreateQuote" class="table DataTableModal table-sm slide-in-top table-hover table-striped text-center mx-auto">
        <thead>
            <tr>
                <th class="text-nowrap">Imagen</th>
                <th class="text-nowrap">Nombre</th>
                <th class=" padding-left-right">Descripción</th>
                <th class=" text-nowrap">Unidad de medida</th>
                <th class=" text-nowrap">Cantidad</th>
            </tr>
        </thead>
        <tbody class="table-light">
            <?php
                foreach ($articles as $art) { ?>
                    <tr>
                        <td>
                            <img class='viewArticle' value="<?= $art['ar_id']?>" src="<?= $art['ar_img_url']?>" alt="..."
                                height="100"
                                data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>"
                                data-value="<?= $art['ar_id'] ?>">
                        </td>
                        <td><?= $art['ar_name']?></td>
                        <td class="truncate"><?= $art['ar_desc']?></td>
                        <td><?= $art['ar_measurement_value']?> KG</td>
                        <td class="table-cell" style="height: 100px;">
                            <input min="1" type="number" class="mt-2 mb-2 quantityinput form form-control" name="quantity" id="">
                            <button data-url="<?= Helpers\generateUrl("Quote","Quote","AddArticlesAjax",[],"ajax");?>"
                                value="<?= $art['ar_id']?>" id="addArticleQuote" class="btn btn-outline-primary">
                                +
                            </button>
                        </td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

