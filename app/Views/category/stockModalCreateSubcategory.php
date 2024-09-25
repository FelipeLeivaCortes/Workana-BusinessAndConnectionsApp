<div class="container">
    <h1 class="tracking-in-expand">Crear Subcategoría <i class="fa-solid fa-clipboard-list"></i></h1>
    <form action="<?= Helpers\generateUrl("Category","Category","insertSubcategory")?>" method="post">
        <div class="col-md-12">
            <label for="">Nombre de la subcategoría</label>
            <input type="text" class="form form-control" name="subcat_name">
        </div>
        <div class="col-md-12">
            <label for="">Descripción de la subcategoría</label>
            <textarea type="text" class="form form-control" name="subcat_desc"></textarea>
        </div>
   
                <?php
                foreach ($category as $cat) {
                    echo "<input type='hidden' value='".$cat['cat_id']."' name='cat_id'>";
                }
                ?>

        <div class="col-md-6 mt-3 mb-3">
            <button class="btn btn-outline-primary">
                Registrar Subcategoría
            </button>
        </div>
    </form>
</div>
