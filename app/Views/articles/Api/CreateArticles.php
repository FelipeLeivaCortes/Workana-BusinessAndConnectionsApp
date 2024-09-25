<div class="container col-md-6 p-4">



    <form action="<?= Helpers\generateUrl("Api", "Api", "CreateArticle") ?>" method="POST"
        enctype="multipart/form-data">
        <div class="form-group mt-2">
            <label for="sku">Codigo producto:</label>
            <input type="text" class="form-control" id="sku" name="sku" required>
        </div>
        <div class="form-group mt-2">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group mt-2">
            <label for="regular_price">Precio regular:</label>
            <input type="text" class="form-control" id="regular_price" name="regular_price" required>
        </div>

        <div class="form-group mt-2">
            <label for="status">Estado del producto:</label>
            <select class="form-control" id="status" name="status">
                <option disabled selected>Seleccione una opción</option>
                <option value="draft">Borrador</option>
                <option value="pending">Pendiente</option>
                <option value="private">Privado</option>
                <option value="publish">Publicado</option>
            </select>
        </div>

        <div class="form-group mt-2">
            <label for="description">Descripción:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="form-group mt-2">
            <label for="short_desc">Descripción corta:</label>
            <textarea class="form-control" id="short_desc" name="short_desc" required></textarea>
        </div>

        <div class="form-group mt-2">
            <label for="stock_quantity">Stock (existencias):</label>
            <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" required>
        </div>

        <div class="form-group mt-3 mb-3">
            <label for="ar_img_url">Imagen:</label>
            <input class="form-control text-end mt-2" type="file" class="form-control-file" id="ar_img_url" name="ar_img_url" accept="image/*" required>
        </div>

        <!-- Si también necesitas un campo para el archivo de datos, descomenta el siguiente bloque -->
        <!-- <div class="form-group">
      <label for="ar_data_url">Archivo de datos:</label>
      <input type="file" class="form-control-file" id="ar_data_url" name="ar_data_url" accept=".pdf,.doc,.docx">
    </div> -->

        <button type="submit" class="btn btn-primary mt-2">Crear artículo</button>
    </form>
</div>