<?php foreach ($warehouse as $wh) {
?>

<div class="col-md-12">
    <div class="card shadow">
        <div class="card-header slide-in-top  bg-light text-center text-white">
            <h3 class="mb-0"> Actualizar </h3>
        </div>
        <div class="card-body swing-in-top-fwd">
            <form action="<?= Helpers\generateUrl("Warehouse","Warehouse","updateWarehouse")?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" value="<?= $wh['wh_name']?>" id="name" name="name"
                                required>
                            <input type="hidden" name="id" value="<?= $wh['wh_id']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">Codigo de bodega:</label>
                            <input type="text" value="<?= $wh['wh_code']?>" class="form-control" id="code" name="code"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="responsible">Responsable:</label>
                            <input type="text" class="form-control" value="<?= $wh['wh_responsible']?>" id="responsible"
                                name="responsible" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="depto">Departamentos:</label>
                                <select name="depto"
                                    data-url="<?php echo Helpers\generateUrl("Access","Access","TownsWithDepto",[],"ajax") ?>"
                                    class="form-select" id="departmentWarehouseUpdate">
                                    <option disabled value="">Seleccione una opcion</option>
                                    <?php foreach ($deptos as $d) {
                                        $selected = ($d['NOMBRE_DEPTO'] == $wh['wh_departament']) ? 'selected' : '';
                                        echo "<option value=".$d['NOMBRE_DEPTO']." ".$selected.">".$d['NOMBRE_DEPTO']."</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-12 divTownsUpdate">
                                <div class="form-group">
                                    <label for="city">Ciudad:</label>
                                    <select name="city" class="form-select">
                                        <option disabled value="">Seleccione una opcion</option>
                                        <?php  foreach ($townsSelected as $c) {
                                        $selected = ($c['NOMBRE_MPIO'] == $wh['wh_city']) ? 'selected' : '';
                                        echo "<option value=".$c['NOMBRE_MPIO']." ".$selected.">".$c['NOMBRE_MPIO']."</option>";
                                    } ?>
                                    </select>
                                </div>
                            </div>

                            <label for="phone">Teléfono:</label>
                            <input type="tel" class="form-control" id="phone" value="<?= $wh['wh_phone']?>" name="phone"
                                required>

                        </div>
                    </div>

                </div>

                <div class="row">


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Dirección:</label>
                            <textarea name="Address" id="Address" class="form form-control" cols="30"
                                rows="2"><?= $wh['wh_address']?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="address">Descripcion bodega:</label>
                        <textarea name="desc" id="desc" class="form form-control" cols="30"
                            rows="2"><?= $wh['wh_desc']?></textarea>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary mt-4">Actualizar</button>
                    </div>
            </form>
        </div>
    </div>

</div>
</div>
<?php 
        } 
        ?>