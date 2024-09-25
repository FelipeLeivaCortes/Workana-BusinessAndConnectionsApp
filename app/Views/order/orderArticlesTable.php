<div class="container ">
    <div class="table-scroll">
        <table id="myTable" class="DataTable truncate text-center table align-middle slide-in-top table-hover">
            <thead class=" truncate">
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
                    <td><img src="<?= $art['ar_img_url']?>" alt="..." height="100"></td>
                    <td><?= $art['ar_name']?></td>
                    <td class="truncate"><?= $art['ar_desc']?></td>
                    <td><?= $art['ar_measurement_value']?>kg</td>
                    <td><?= $art['color'][0]['color_name']?></td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <input type="number" min="1" name="quantity" class="form-control w-75" id="">
                            <button
                                data-url="<?= Helpers\generateUrl("Order", "Order", "AddArticlesAjax", [], "ajax"); ?>"
                                value="<?= $art['ar_id'] ?>" id="addArticles" class="btn btn-outline-success"><i
                                    class="fa-regular fa-square-plus"></i></button>
                        </div>


                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>