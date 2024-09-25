<div class="container p-4">
    <h1 class="text-center">Asignar metodos de Pago</h1>
    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <!-- Cambia las clases para cambiar los colores -->
            <button style="border:1px solid #d9dee3;color:black;" class="nav-link active btn-secondary" id="v-pills-home-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                aria-selected="true">Metodos de pago</button>
            <!-- Cambia las clases para cambiar los colores -->
            <button  style="border:1px solid #d9dee3;color:black;" class="nav-link btn-secondary" id="v-pills-profile-tab"
                data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"
                aria-controls="v-pills-profile" aria-selected="false">Crear metodos de pago</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                tabindex="0">
                <!-- Formulario para seleccionar métodos de pago existentes -->
                <form action="<?= Helpers\generateUrl("Clients", "Clients", "paymentMethodsCompany") ?>" method="POST">
                    <div class="form-group text-center">
                        <label for="empresa">Empresa:</label>
                        <h3><?= $company[0]['c_name'] ?></h3>
                        <input type="hidden" value="<?= $company[0]['c_id'] ?>" name="c_id">
                    </div>
                    <div class="form-group">
                        <label>Métodos de Pago:</label>
                        <div id="contMethodsPay">

                            <?php foreach ($methodsPay as $m) { ?>
                            <div class="form-check">
                                <?php
                                $isChecked = false;
                                foreach ($company[0]['payment_methods'] as $pm) {
                                    if ($pm['payment_method_id'] === $m['payment_method_id']) {
                                        $isChecked = true;
                                        break;
                                    }
                                }
                                ?>
                                <input type="checkbox" class="form-check-input"
                                    id="metodo<?= $m['payment_method_id'] ?>" name="method_pay[]"
                                    value="<?= $m['payment_method_id'] ?>" <?php if ($isChecked) echo 'checked'; ?>>
                                <label class="form-check-label"
                                    for="metodo<?= $m['payment_method_id'] ?>"><?= $m['name'] ?></label>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar Métodos de Pago</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"
                tabindex="0">

                <!-- Formulario para agregar nuevos métodos de pago -->
                <form action="<?= Helpers\generateUrl("Clients", "Clients", "addPaymentMethod",[],"ajax") ?>"
                    id="addMethodsPay" method="POST">
                    <div class="mb-3">
                        <h2 class="text-center">Agregar Nuevo Método de Pago</h2>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_metodo" class="form-label">Nuevo Método de Pago:</label>
                        <input type="text" class="form-control" id="newMethod" name="newMethod" required>
                        <input type="hidden" value="<?= $company[0]['c_id'] ?>" name="c_id">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="addMethodsPayButton">Agregar Método de
                            Pago</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




</div>