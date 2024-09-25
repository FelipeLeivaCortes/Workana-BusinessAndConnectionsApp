<div class="container">
    <h1 class="tracking-in-expand">Bodegas <i class="fas fa-warehouse"></i></h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header slide-in-top bg-light text-center text-white">
                    <h3 class="mb-0"> Información de registro</h3>
                </div>
                <div class="card-body swing-in-top-fwd">
                    <form action="<?= Helpers\generateUrl("Warehouse","Warehouse","InsertWarehouse") ?>" method="POST"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre bodega:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Codigo de bodega:</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>

                                <div class="form-group">
                                    <label for="responsible">Responsable:</label>
                                    <input type="text" class="form-control" id="responsible" name="responsible"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="depto">Departamentos:</label>
                                    <select name="depto"
                                        data-url="<?php echo Helpers\generateUrl("Access","Access","TownsWithDepto",[],"ajax") ?>"
                                        class="form-select" id="departmentWarehouse">
                                        <option selected disabled value="">Seleccione una opcion</option>
                                        <?php foreach ($deptos as $d) {
                                              echo "<option value=".$d['NOMBRE_DEPTO'].">".$d['NOMBRE_DEPTO']."</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="divTowns">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">Teléfono:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Dirección:</label>
                                    <textarea name="Address" id="Address" class="form form-control" cols="30"
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Descripcion bodega:</label>
                                    <textarea name="desc" id="desc" class="form form-control" cols="30"
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary mt-4">Crear</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="container mt-4 ">
    <div class="slide-in-top card-header bg-light text-center text-white">
        <h3 class="mb-0"><i class="fas fa-warehouse"></i> Bodegas registradas</h3>
    </div>
    <div class="table-responsive">


        <table class="table DataTable table-hover slide-in-top table-stripe">
            <thead>
                <tr>
                    <th>Nombre de la Bodega</th>
                    <th>Código de Bodega</th>
                    <th>Responsable</th>
                    <th>Departamento</th>
                    <th>Ciudad</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($warehouse as $wh) { ?>
                <tr>
                    <td><?= $wh['wh_name'] ?></td>
                    <td><?= $wh['wh_code'] ?></td>
                    <td><?= $wh['wh_responsible'] ?></td>
                    <td><?= $wh['wh_departament'] ?></td>
                    <td><?= $wh['wh_city'] ?></td>
                    <td><?= $wh['wh_date'] ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button
                                data-url="<?= Helpers\generateUrl("Warehouse", "Warehouse", "deleteWarehouse", [], "ajax"); ?>"
                                data-value="<?= $wh['wh_id'] ?>" class="btn btn-outline-danger deleteWarehouse">
                                Eliminar
                            </button>
                            <button
                                data-url="<?= Helpers\generateUrl("Warehouse", "Warehouse", "ViewModalWarehouse", [], "ajax"); ?>"
                                class="btn btn-outline-primary buttonOpenWarehouse" data-value="<?= $wh['wh_id']; ?>">
                                Editar
                            </button>
                            <button
                                data-url="<?= Helpers\generateUrl("Warehouse", "Warehouse", "ViewWarehouseArticles", ['wh_id' => $wh['wh_id']], "ajax"); ?>"
                                class="buttonOpenWhArticles btn btn-outline-success">
                                Ver Artículos
                            </button>
                        </div>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-2 col-md-12 text-center">

        <button id="scrollToTopBtn" class="btn btn-primary"><i class='bx bxs-up-arrow'></i></button>
    </div>
</div>


</div>