<div class="container">

    <h1>Actualizar Articulo</h1>
    
    <form id="form" action="<?=Helpers\generateUrl("Stock","Stock","UpdateArticleStock")?>" method="POST" enctype="multipart/form-data">
        <div class="container row d-flex">

            <!-- PRIMERA FILA -->
            <div class="col-md-6">
                <label for="">Imagen:</label>
                <div class="col-md-3 p-2">
                    <a class="btn btn-outline-primary" href="<?= $article['ar_img_url'] ?? '#'?>" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-eye"></i></a>
                </div>

                <input id="imageInput" type="file" name="ar_img_url" class="form form-control">
                <div id="imageError" style="color: red;"></div>
            </div>

            <div class="col-md-6">
                <label for="">Ficha tecnica:</label>
                <div class="col-md-3 p-2">
                    <a class="btn btn-outline-primary" href="<?= $article['ar_data_url'] ?? '#' ?>" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-eye"></i></a>
                </div>

                <input type="file" id="docsPdfUpdateArticle" name="ar_data_url" class="form form-control">
                <div id="docsPdfError" style="color: red;"></div>
            </div>


            <!-- SEGUNDA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Nombre:</label>
                <input type="hidden" name="ar_id" value="<?= $article['ar_id'] ?>">
                <input type="text" name="ar_name" id="" value="<?= $article['ar_name'] ?>" class="form form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label for="">Bodega:</label>
                <select name="warehouse" class="form-select" id="">
                    <option disabled="true" selected="true">Seleccione</option>

                    <?php foreach ($warehouses as $wh) {?>
                        <option value="<?=$wh['wh_id'];?>">
                            <?=$wh['wh_name'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <!-- TERCERA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Lote:</label>
                <input type="text" name="stock_lote" id="" value="<?=$s['stock_lote'] ?? 'Sin Lote'?>" class="form form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label for="">Codigo articulo (SAP code):</label>
                <input type="text" value="<?=$article['ar_code']?>" name="ar_code" id="" class="form form-control">
            </div>


            <!-- CUARTA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Entrada:</label>
                <input type="hidden" value="<?=$s['stock_id'] ?? null?>" name="stock_id">
                <input type="date" name="stock_date_entry" value="<?=$s['stock_date_entry']?>" id="" class="form form-control">
            </div>

            <div class="col-md-6 mt-3">
                <input type="checkbox" name="date_expiration" id="date_expiration_checkbox"
                    <?= empty($s['stock_expiration_date']) ? '' : 'checked' ?>>

                <label for="date_expiration_checkbox">Fecha de vencimiento?</label>

                <?php if (!empty($s['stock_expiration_date'])) { ?>
                    <input type="date" name="stock_expiration_date" id="stock_expiration_date_input" class="form form-control" value="<?= $s['stock_expiration_date'] ?>">
                <?php } else { ?>
                    <input type="date" name="stock_expiration_date" id="stock_expiration_date_input" class="form form-control" disabled>
                <?php } ?>
            </div>


            <!-- QUINTA FILA -->
            <script>
                var stockExpirationDate = "<?= $s['stock_expiration_date'] ?>";
            </script>

            <div class="col-md-6 mt-3">
                <label for="">Unidad de medida:</label>
                <select name="mt_id" class="form-select" id="unidad-medida">
                    <option disabled="true" selected="true">Seleccione</option>

                    <?php foreach ($measurements as $mt) {?>
                        <option value="<?=$mt['mt_id'];?>" <?php if ($mt['mt_id'] == $article['mt_id']) { echo "selected"; } ?>>
                            <?=$mt['mt_name'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6 mt-3" <?php if ($article['mt_id'] == 8) { echo 'style="display: none;"'; } ?> id="input-div">
                <label for="">Valor de medida:</label>

                <div class="input-group">
                    <input type="number" value="<?= $article['ar_measurement_value']?>" name="ar_measurement_value" id="input-value" class="form-control" step="0.01">
                </div>

                <script>
                    var valueQuantity = "<?= $article['ar_measurement_value'] ?>";
                </script>
            </div>


            <!-- SEXTA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Color:</label>
                <select name="color" class="form-select" id="color">
                    <option disabled="true" selected="true">Seleccione</option>

                    <?php foreach ($colors as $co) {
                        $colorCode  = $co['color_code'];
                        $colorName  = $co['color_name'];
                        $selected   = ($co['color_id'] == $article['color_id']) ? 'selected' : '';

                        echo '<option value="'.$co['color_id'].'" style="background-color: '.$colorCode.';" '.$selected.'>'.$colorName.'</option>';
                    } ?>
                </select>
            </div>

            <div class="col-md-6 mt-3">
                <label for="">Categoria:</label>
                <select data-url="<?= Helpers\generateUrl("Stock","Stock","subcategoriesAjax",[],"ajax")?>" name="category" class="form-select" id="subcategoriesAjax">
                    <option disabled="true" selected="true">Seleccione</option>
                    
                    <?php foreach ($categories as $cat) {
                        $selected = ($cat['cat_id'] == $article['cat_id']) ? 'selected' : '';
                    ?>

                        <option value="<?=$cat['cat_id'];?>" <?=$selected;?>><?=$cat['cat_name'];?></option>
                    <?php } ?>
                </select>
            </div>


            <!-- SEPTIMA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Subcategoria:</label>
                <div class="col-md-12" id="containerSub">
                    <select name="subcategory" id="subcategory" class="form form-select">
                        <?php foreach ($subcategories as $sub) {?>
                            <option value="<?=$sub['sbcat_id'];?>"
                                <?php if ($sub['sbcat_id'] == $article['sbcat_id']) echo 'selected'; ?>>
                                <?=$sub['sbcat_name'];?>
                            </option>
                        <?php  }?>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <label for="">Cantidad:</label>
                <input type="number" name="stock_Quantity" value="<?=$stockArticle['stock_Quantity']?>" id="" class="form form-control">
            </div>


            <!-- OCTAVA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Precio unidad:</label>
                <input type="number" name="p_value" id="" value="<?=$priceArticle['p_value']?>" class="form form-control">
                <input type="hidden" name="p_id" value="<?=$priceArticle['p_id']?>">
            </div>


            <!-- NOVENA FILA -->
            <div class="col-md-12 mt-3">
                <label for="">Descripción:</label>
                <textarea class="form form-control" name="ar_desc" rows="10"><?=$article['ar_desc']?></textarea>
            </div>


            <!-- DECIMA FILA -->
            <div class="col-md-6 mt-3">
                <label for="">Características:</label>
                <textarea id="textarea-list" class="form form-control" rows="10">
                    <?php
                        $characteristics = explode(';', $article['ar_characteristics']);
                        echo implode("\n", $characteristics);
                    ?>
                </textarea>
            </div>

            <!-- DECIMA FILA -->
            <div class="col-md-6 mt-3">
                <label for=""></label>
                <input type="hidden" value="<?=$article['ar_characteristics']?>" name="ar_characteristics">
                <div class="col-md-6">
                    <ul id="list">
                        <?php
                            $characteristics    = explode(';', $article['ar_characteristics']);

                            foreach ($characteristics as $item) {
                                echo "<li>$item</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>


            <!-- BOTÓN ACTUALIZACIÓN -->
            <div class="col-md-12 mt-5 mb-2 text-center">
                <button class="btn btn-outline-primary"> Actualizar Articulo</button>
            </div>
        </div>
    </form>

    <script type="text/javascript" defer>
        document.addEventListener('DOMContentLoaded', function() {
            $('#form').on('submit', function(event){
                event.preventDefault();

            });
        });
    </script>
</div>
