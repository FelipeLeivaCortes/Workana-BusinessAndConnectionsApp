<div class="card-header slide-in-top  bg-dark text-center">
    <h3 class="mb-0 text-white">Actualizar lista de precio</h3>
</div>
<form action="<?= Helpers\generateUrl("Groups","Groups","updateListGroups")?>" method="post">
    <div class="container p-4">
        <div class="row d-flex">
            <div class="col-md-6">
                <?php

                use function Helpers\dd;

 foreach ( $group as $gp): ?>

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="hidden" name="gp_id" value="<?=$gp['gp_id']?>">
                    <input type="text" value="<?=$gp['gp_name']?>" class="form-control" id="nombre" name="nameGroup"
                        required>
                </div>
                <label for="">Descuento:</label>
                <div class="input-group mb-3">
                    <?php
                    $discountPercentage = $gp['gp_discount_percentage'];
                    if (!empty($discountPercentage)) {
                        echo '<input type="number" step="0.01" min="0" max="100" id="discount_percentage" value="' . $discountPercentage . '" name="discount_percentage" class="form-control" aria-label="Amount (to the nearest dollar)">';
                    } else {
                        echo '<input type="number" step="0.01" min="0" max="100" id="discount_percentage"  name="discount_percentage" class="form-control" aria-label="Amount (to the nearest dollar)" disabled>';
                    }
                    ?>
                    <span class="input-group-text">%</span>
                </div>

                <?php endforeach; ?>
                <label for="">Fecha finalizacion:</label>
                <div class="input-group mb-3">
                    
                    <input class="form-control" type="datetime-local" value="<?= $gp['gp_date_end_discount']; ?>" name="date_end" id="date_end">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Cupon:</label>
                    <input type="text" value="<?= $group[0]['gp_coupon']?>" class="form-control" name="coupon" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Precio:</label>
                    <?php
                $priceDiscount = $result[0]['price_discount'];
                if (!empty($priceDiscount)) {
                    echo '<input type="text" id="price" value="' . $priceDiscount . '" class="form-control" name="price" required>';
                } else {
                    echo '<input type="text" id="price" class="form-control" name="price" disabled>';
                }
                ?>
                </div>

            </div>



        </div>
    </div>
    <!-- START -->
    <div class="container p-4">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <label for="nombre">Categorías seleccionadas:</label>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="form-group col-md-6">

                            <label for="nombre">Categoria:</label>
                            <div class="input-group">
                                <input type="search" id="categorySearch" class="form-control"
                                    placeholder="Buscar categoría...">
                                <div id="categoryOptions" class="category-dropdown" style="display: none;">
                                    <!-- Opciones de categoría -->
                                    <?php foreach ($categories as $category): ?>
                                    <div class="category-option" data-value="<?php echo $category['cat_id']; ?>">
                                        <?php echo $category['cat_name']; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" id="addCategoryButton" class="btn btn-primary add-item">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">

                            <div id="selectedCategories" class="row">
                                <!-- Aquí se mostrarán las categorías seleccionadas -->
                                <?php
                                foreach ($ADDcategories as $cats) {
                                    echo '<div class="col-md-3 mt-2"><span class="selected-category badge bg-primary" data-value="'.$cats['cat_id'].
                                    '">' .$cats['cat_name'].
                                    '<i class="fa-solid fa-circle-xmark remove-category"></i></span>
                                    <input type="hidden" value="'.$cats['cat_id'].'" name="categories[]" ></div>';
                                }
                                
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Subcategorias seleccionadas:
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="form-group col-md-6">
                            <label for="nombre">Subcategoria:</label>
                            <div class="input-group">
                                <input type="search" id="subcategorySearch" class="form-control"
                                    placeholder="Buscar categoría...">
                                <div id="subcategoryOptions" class="subcategory-dropdown" style="display: none;">
                                    <?php foreach ($subcategories as $subcategory): ?>
                                    <div class="subcategory-option"
                                        data-value="<?php echo $subcategory['sbcat_id']; ?>">
                                        <?php echo $subcategory['sbcat_name']; ?>
                                    </div>
                                    <?php endforeach; ?>

                                </div>
                                <button type="button" id="addSubcategoryButton" class="btn btn-primary add-item"
                                    data-column="columna3"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="selectedSubcategories" class="row">
                                <!-- Aquí se mostrarán las categorías seleccionadas -->
                                <?php
                                foreach ($ADDsubcategories as $sbcats) {
                                    echo '<div class="col-md-3 mt-2"><span class="selected-subcategory badge bg-primary" data-value="'.$sbcats['sbcat_id'].
                                    '">' .$sbcats['sbcat_name'].
                                    '<i class="fa-solid fa-circle-xmark remove-subcategory"></i></span>
                                    <input type="hidden" value="'.$sbcats['sbcat_id'].'" name="subcategories[]" ></div>';
                                }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Clientes seleccionadas:
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="form-group col-md-6">
                            <label for="nombre">Compañia:</label>

                            <div class="input-group">
                                <input type="search" id="companySearch" class="form-control"
                                    placeholder="Buscar categoría...">
                                <div id="companyOptions" class="company-dropdown" style="display: none;">

                                    <?php foreach ($companies as $company): ?>
                                    <div class="company-option" data-value="<?php echo $company['c_id']; ?>">
                                        <?php echo $company['c_name']; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <button type="button" id="addCompanyButton" class="btn btn-primary add-item"
                                    data-column="columna1"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>

                        <div class="form-group">

                            <div id="selectedCompanies" class="row">
                                <!-- Aquí se mostrarán las categorías seleccionadas -->
                                <?php
                                foreach ($ADDcompanies as $companies) {
                                    echo '<div class="col-md-3 mt-2"><span class="selected-company badge bg-primary" data-value="'.$companies['c_id'].
                                    '">' .$companies['c_name'].
                                    '<i class="fa-solid fa-circle-xmark remove-company"></i></span>
                                    <input type="hidden" value="'.$companies['c_id'].'" name="companies[]" ></div>';
                                }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        Articulos seleccioandos:
                        <!-- Cambiado el número para hacerlo único -->
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="form-group col-md-6">
                            <label for="nombre">Articulos:</label>
                            <div class="input-group">
                                <input type="search" id="articleSearch" class="form-control"
                                    placeholder="Buscar categoría...">
                                <div id="articleOptions" class="article-dropdown" style="display: none;">
                                    <?php foreach ($articles as $article): ?>
                                    <div class="article-option" data-value="<?php echo $article['ar_id']; ?>">
                                        <?php echo $article['ar_name']; ?>
                                    </div>
                                    <?php
                                endforeach; ?>
                                </div>
                                <button type="button" id="addArticleButton" class="btn btn-primary add-item"
                                    data-column="columna4"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                        <div class="form-group">

                            <div id="selectedArticle" class="row">
                                <!-- Aquí se mostrarán las categorías seleccionadas -->
                                <?php
                                foreach ($ADDarticles as $articles) {
                                    echo '<div class="col-md-3 mt-2"><span class="selected-article badge bg-primary" data-value="'.$articles['ar_id'].
                                    '">' .$articles['ar_name'].
                                    '<i class="fa-solid fa-circle-xmark remove-article"></i></span>
                                    <input type="hidden" value="'.$articles['ar_id'].'" name="articles[]" ></div>';
                                }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- ennd -->
    <div class="container">


        <div class="col-md-12 text-center mt-4 mb-4">
            <button type="submit" class="btn btn-outline-primary">Actualizar Lista</button>
        </div>
    </div>
</form>