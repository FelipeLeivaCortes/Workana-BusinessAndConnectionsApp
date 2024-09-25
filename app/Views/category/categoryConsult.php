<div class="container">
    <div class="col-md-12 d-flex">
        <div class="col-md-6 p-2">
            <form id="categoryForm" action="<?= Helpers\generateUrl("Category","Category","insertCategory")?>" method="post">
                <h1 class="tracking-in-expand">Categorias <i class="fa-solid fa-clipboard-list"></i></h1>

                <div class="col-md-12">
                    <label for="">Nombre de la categoria</label>
                    <input type="text" class="form form-control" name="cat_name">
                </div>
                <div class="col-md-12">
                    <label for="">Descripción de la categoria</label>
                    <textarea type="text" class="form form-control" name="cat_desc"></textarea>
                </div>

                <div class="col-md-6 mt-3">
                    <button class="btn btn-outline-primary">
                        Registrar categoria
                    </button>
                </div>

            </form>
        </div>
    </div>

    <hr>
    <div class="table-responsive">
        <table class="table DataTable table-striped table-hover">
            <thead >
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Subcategorias</th>
                    <th>Acciones</th>
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
                <?php foreach ($categories as $cate): ?>
                <tr>
                    <td><?= $cate['cat_id'] ?></td>
                    <td><?= $cate['cat_name'] ?></td>
                    <td class="text-ellipsis"><?= $cate['cat_desc'] ?></td>
                    <td class="text-ellipsis">
                        <?php if (count($cate['subcategories']) > 0): ?>
                        <?php foreach ($cate['subcategories'] as $subcat): ?>
                        <?= $subcat['sbcat_name'] ?>,
                        <?php endforeach; ?>
                        <?php else: ?>
                        Vacío
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-success subcatView"
                                data-url="<?= Helpers\generateUrl("Category","Category","createSubcategoryModal",[],"ajax") ?>"
                                data-id="<?= $cate['cat_id'] ?>">Crear </button>
                            <button data-url="<?=Helpers\generateUrl("Category","Category","UpdateCategoryModal",[],"ajax")?>" data-catid="<?=$cate['cat_id']?>" class="btn btn-outline-primary updateCategory">Editar</button>
                            <?php if (count($cate['subcategories']) === 0): ?>
                            <button data-url="<?=Helpers\generateUrl("Category","Category","DeleteCategory",[],"ajax")?>" class="btn btn-outline-danger deleteCategory" data-catid="<?=$cate['cat_id']?>" >Eliminar</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>


    </div>
</div>