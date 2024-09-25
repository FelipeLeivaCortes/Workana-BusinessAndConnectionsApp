<?php foreach ($category as $cat) {?>
<div class="col-md-12 d-flex">
        <div class="col-md-12 p-2">
            <form action="<?= Helpers\generateUrl("Category","Category","updateCategory")?>" method="post" >
                <h1 class="tracking-in-expand">Categorias <i class="fa-solid fa-clipboard-list"></i></h1>

                <div class="col-md-12">
                    <label for="">Nombre de la categoria</label>
                    <input type="hidden" name="cat_id" value="<?=$cat['cat_id']?>">
                    <input type="text" class="form form-control" value="<?=$cat['cat_name']?>" name="cat_name">
                </div>
                <div class="col-md-12">
                    <label for="">Descripción de la categoria</label>
                    <textarea type="text" class="form form-control" name="cat_desc"><?=$cat['cat_desc']?></textarea>
                </div>

                <div class="col-md-6 mt-3">
                    <button class="btn btn-outline-primary">
                        Actualizar 
                    </button>
                </div>

            </form>
        </div>
    </div>
<?php
} 
?>