<div class="container">

    <h1 class="tracking-in-expand">Listas de precios <i class="fa-solid fa-pen-to-square"></i></h1>
    <div class="col-md-12 ">
        <div>
            <button data-url="<?= Helpers\generateUrl("Groups","Groups","viewModalCreate",[],"ajax");?>"
                class="btn btn-primary" id="createGroup">Crear lista de Precio</button>
        </div>
    </div>

    <hr>
    <h1 class="tracking-in-expand">Listas <i class="fa-solid fa-list"></i></h1>
    <div class="container table-responsive">
        <table id="myTable" class="DataTable text-center table align-middle slide-in-top table-hover">
            <thead >
                <tr>
                    <th >Nombre</th>
                    <th >Empresa/s</th>
                    <th >Articulo/s</th>
                    <th >Categorias</th>
                    <th >Subcategorias</th>
                    <th >Finaliza</th>
                    <th >Action</th>
                </tr>
                <tr>
                    <th></th>
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
                foreach ($groups as $gps) {

                    $companyNames = [];
                    foreach ($gps['Companies'] as $companies) {
                        foreach ($companies as $company) {
                            $companyNames[] = $company['c_name'];
                        }
                    }
                    $companyNames = implode(', ', $companyNames);

                    $articleNames = [];
                    foreach ($gps['Articles'] as $articles) {
                        foreach ($articles as $article) {
                            $articleNames[] = $article['ar_name'];
                        }
                    }
                    $articleNames = implode(', ', $articleNames);

                    $categoryNames = [];
                    foreach ($gps['Categories'] as $categories) {
                        foreach ($categories as $category) {
                            $categoryNames[] = $category['cat_name'];
                        }
                    }
                    $categoryNames = implode(', ', $categoryNames);

                    $subcategoryNames = [];
                    foreach ($gps['Subcategories'] as $subcategories) {
                        foreach ($subcategories as $subcategory) {
                            $subcategoryNames[] = $subcategory['sbcat_name'];
                        }
                    }
                    $subcategoryNames = implode(', ', $subcategoryNames);
                ?>
                <tr>
                    <td><?= $gps['gp_name'] ?></td>
                    <td>
                        <div class="text-truncate"><?= $companyNames ?></div>
                    </td>
                    <td>
                        <div class="text-truncate"><?= $articleNames ?></div>
                    </td>
                    <td>
                        <div class="text-truncate"><?= $categoryNames ?></div>
                    </td>
                    <td>
                        <div class="text-truncate"><?= $subcategoryNames ?></div>
                    </td>
                    <td><?= $gps['gp_date_end_discount'] ?></td>
                    <td>
                        <button
                            data-url="<?= Helpers\generateUrl("Groups", "Groups", "viewModalUpdateGroup", [], "ajax") ?>"
                            data-id="<?= $gps['gp_id'] ?>" id="editLisPrice" class="btn btn-primary">Editar lista
                        </button>
                    </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>


</div>