<div class="container">

    <h1>Crear Articulo</h1>
    <form action="<?=Helpers\generateUrl("Stock","Stock","insertArticleStock")?>" method="POST"
        enctype="multipart/form-data">
        <div class="container row d-flex">
            <div class="col-md-6">
                <label for="">Imagen:</label>
                <input type="file" name="ar_img_url" class="form form-control image-upload">
            </div>
            <div class="col-md-6">
                <label for="">Ficha tecnica:</label>
                <input type="file" name="ar_data_url" class="form form-control document-upload">
            </div>
            <div class="col-md-6">
                <label for="">Nombre:</label>
                <input type="text" name="ar_name" id="" class="form form-control">

            </div>
            <div class="col-md-6">
                <label for="">Bodega:</label>
                <select name="warehouse" class="form-select" id="">
                    <option disabled="true" selected="true">Seleccione</option>
                    <?php foreach ($warehouses as $wh) {?>
                    <option value="<?=$wh['wh_id'];?>"><?=$wh['wh_name'];?></option>
                    <?php  }?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="">Lote:</label>
                <input type="text" name="stock_lote" id="" class="form form-control">

            </div>
            <div class="col-md-6">
                <label for="">Codigo articulo:</label>
                <input type="text" name="ar_code" id="" class="form form-control">

            </div>
            <div class="col-md-6">
                <label for="">Entrada:</label>
                <input type="date" name="stock_date_entry" id="" class="form form-control">

            </div>
            <div class="col-md-6">
                <input type="checkbox" name="date_expiration" id="date_expiration_checkbox">
                <label for="date_expiration_checkbox">Fecha de vencimiento?</label>
                <input type="date" name="stock_expiration_date" disabled id="stock_expiration_date_input"
                    class="form form-control">
            </div>

            <div class="col-md-6">
                <label for="">Unidad de medida:</label>
                <select name="mt_id" class="form-select" id="unidad-medida">
                    <option disabled="true" selected="true">Seleccione</option>
                    <?php foreach ($measurements as $mt) {?>
                    <option value="<?=$mt['mt_id'];?>"><?=$mt['mt_name'];?></option>
                    <?php  }?>
                </select>
            </div>

            <div id="input-div" class="col-md-6">

                <label for="">Valor de medida:</label>
                <div class="input-group">
                    <input type="number" name="ar_measurement_value" id="input-value" class="form-control" step="0.01">
                </div>
            </div>


            <div class="col-md-6">
                <label for="">Color:</label>
                <select data-url="<?= Helpers\generateUrl("Stock","Stock","subcategoriesAjax",[],"ajax")?>" name="color_id"
                    class="form-select" id="color">
                    <option disabled="true" selected="true">Seleccione</option>
                    <?php foreach ($colors as $co) {
                    $colorCode = $co['color_code'];
                    $colorName = $co['color_name'];
                    echo '<option value="'.$co['color_id'].'" style="background-color: '.$colorCode.';">'.$colorName.'</option>';
            }?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="">Categoria:</label>
                <select data-url="<?= Helpers\generateUrl("Stock","Stock","subcategoriesAjax",[],"ajax")?>"
                    name="cat_id" class="form-select" id="category">
                    <option disabled="true" selected="true">Seleccione</option>
                    <?php foreach ($categories as $cat) {?>
                    <option value="<?=$cat['cat_id'];?>"><?=$cat['cat_name'];?></option>
                    <?php  }?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="">Subcategoria:</label>
                <div class="col-md-12" id="containerSub">
                </div>
            </div>

            <div class="col-md-6">
                <label for="">Cantidad en stock:</label>
                <input type="number" name="stock_Quantity" id="" class="form form-control">

            </div>
            <div class="col-md-6">
                <label for="">Precio unidad:</label>
                <input type="number" name="p_value" id="" class="form form-control">
            </div>
            <div class="col-md-12">
                <label for="">Descripción:</label>
                <textarea class="form form-control" name="ar_desc" rows="10"></textarea>

            </div>
            <div class="col-md-6">
                <label for="">Características:</label>
                <textarea id="textarea-list"  name="ar_characteristics" rows="10"></textarea>

            </div>
            <div class="col-md-6">
                <label for=""></label>
                <input type="hidden" name="ar_characteristics">
                <ul id="list"></ul>
            </div>
            <div class="col-md-12 mt-2 mb-2 text-center">
                <button class="btn btn-outline-primary"> Guardar Articulo</button>
            </div>

    </form>
</div>