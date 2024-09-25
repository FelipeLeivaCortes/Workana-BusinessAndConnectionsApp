<!-- Nav tabs -->
<ul class="nav nav-tabs custom-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active custom-tab" id="companyInfo-tab" data-bs-toggle="tab" href="#companyInfo" role="tab"
            aria-controls="companyInfo" aria-selected="true">Información de la Compañía</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link custom-tab" id="additionalInfo-tab" data-bs-toggle="tab" href="#additionalInfo" role="tab"
            aria-controls="additionalInfo" aria-selected="false">Información Adicional</a>
    </li>
</ul>

<!-- Tab content -->
<div class="tab-content custom-tab-content" id="myTabsContent">
    <!-- Tab 1: Información de la Compañía -->
    <div class="tab-pane fade show active custom-tab-pane" id="companyInfo" role="tabpanel"
        aria-labelledby="companyInfo-tab">
        <!-- Tu formulario actual de Información de la Compañía -->
        <div class="container">
            <h1>Actualizar información de la compañia</h1>

            <?php foreach ($company as $comp) { ?>
            <form action="<?php echo Helpers\generateUrl("Company","Company","UpdateDataCompany",[],"ajax")?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_name">Nombre de la compañía</label>
                            <input type="text" id="c_name" name="c_name" class="form-control" value="<?php echo $comp['c_name']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="NIT">Número de identificación tributaria (NIT)</label>
                            <input type="text" id="NIT" name="NIT" class="form-control"
                                value="<?php echo $comp['c_num_nit']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="numVerNIT">N° Verificación</label>
                            <input  name="numVerNIT" id="numVerNIT" type="number" class="form-control" min="0" value="<?php echo $comp['c_num_ver_nit']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Industria</label>
                            <select name="industry" id="industry" class="form-select">
                                <?php foreach ($industries as $i) { ?>
                                <option value="<?=$i['tpi_id']?>"
                                    <?php if($i['tpi_id'] == $comp['tpi_id']) echo 'selected'; ?>>
                                    <?=$i['industry_name']?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_desc">Descripción</label>
                            <textarea id="c_desc" name="c_desc" class="form-control"><?php echo $comp['c_desc'] ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>


                <!-- SEPARADOR CON LA SECCIÓN DE LA DIRECCIÓN DE FACTURACIÓN -->
                <hr class="mt-5">

                <div class="row mt-3">
                    <h4 class="h4">Dirección de Facturación</h4>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_street">Calle</label>
                            <input type="text" id="c_street" name="c_street" class="form-control" value="<?php echo $comp['c_street'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_apartament">Departamento</label>
                            <input type="text" id="c_apartament" name="c_apartament" class="form-control" value="<?php echo $comp['c_apartament'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_country">País</label>
                            <input type="text" id="c_country" name="c_country" class="form-control" value="<?php echo $comp['c_country'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_state">Estado</label>
                            <input type="text" id="c_state" name="c_state" class="form-control" value="<?php echo $comp['c_state'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_city">Ciudad</label>
                            <input type="text" id="c_city" name="c_city" class="form-control" value="<?php echo $comp['c_city'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_postal_code">Código Postal</label>
                            <input type="text" id="c_postal_code" name="c_postal_code" class="form-control" value="<?php echo $comp['c_postal_code']; ?>">
                        </div>
                    </div>
                </div>


                <!-- SEPARADOR CON LA SECCIÓN DE LA DIRECCIÓN DE ENTREGA -->
                <hr class="mt-5">

                <div class="row mt-3">
                    <h4 class="h4">Dirección de Entrega</h4>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="useClientDataCheckbox">
                    <label class="form-check-label" for="useClientDataCheckbox">Usar datos Cliente?</label>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingStreet">Calle</label>
                            <input type="text" id="c_shippingStreet" name="c_shippingStreet" class="form-control" value="<?php echo $comp['c_shippingStreet'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingApartament">Departamento</label>
                            <input type="text" id="c_shippingApartament" name="c_shippingApartament" class="form-control" value="<?php echo $comp['c_shippingApartament'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingCountry">Pais</label>
                            <input type="text" id="c_shippingCountry" name="c_shippingCountry" class="form-control" value="<?php echo $comp['c_shippingCountry'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingState">Estado</label>
                            <input type="text" id="c_shippingState" name="c_shippingState" class="form-control" value="<?php echo $comp['c_shippingState'] ?? ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingCity">Ciudad</label>
                            <input type="text" id="c_shippingCity" name="c_shippingCity" class="form-control" value="<?php echo $comp['c_shippingCity'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c_shippingPostalcode">Código Postal</label>
                            <input type="text" id="c_shippingPostalcode" name="c_shippingPostalcode" class="form-control" value="<?php echo $comp['c_shippingPostalcode'] ?? ''; ?>">
                        </div>
                    </div>
                </div>


                <!-- SEPARADOR CON LA SECCIÓN REPRESENTANTE -->
                <hr class="mt-5">

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_name">Nombre/s representante</label>
                            <?php foreach ($comp['representant'] as $rep) { ?>
                            <input type="text" id="representative_name" name="representative_name" class="form-control"
                                value="<?php echo $rep['u_name']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_lastname">Apellido/s representante</label>
                            <?php foreach ($comp['representant'] as $rep) { ?>
                            <input type="text" id="representative_lastname" name="representative_lastname"
                                class="form-control" value="<?php echo $rep['u_lastname']; ?>">
                            <input type="hidden" name="u_id" value="<?php echo $rep['u_id']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_document_type">Tipo de documento</label>
                            <select id="representative_document_type" name="representative_document_type"
                                class="form-select" required>
                                <option value="" disabled>Seleccione una opción</option>
                                <?php
                                    $documentTypes = array("Cedula de ciudadanía","Tarjeta de extranjeria","Tarjeta de identidad", "Cedula de extranjeria", "Pasaporte","NIT");
                                    foreach ($documentTypes as $type) {
                                        $selected = ($type == isset($comp['representant'][0]['u_document_type'])) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $type; ?>" <?php echo $selected; ?>><?php echo $type; ?>
                                    </option>
                                    <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_email">Correo electrónico</label>
                            <?php foreach ($comp['representant'] as $rep) { ?>
                            <input type="email" id="representative_email" name="representative_email"
                                class="form-control" value="<?php echo $rep['u_email']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_document">Número de documento</label>
                            <?php foreach ($comp['representant'] as $rep) { ?>
                            <input type="text" id="representative_document" name="representative_document"
                                class="form-control" value="<?php echo $rep['u_document']; ?>">
                            <?php } ?>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="representative_document">Número de documento</label>
                            <?php foreach ($comp['representant'] as $rep) { ?>
                            <input type="text" id="representative_document" name="representative_document"
                                class="form-control" value="<?php echo $rep['u_document']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="container p-4">
                    <input type="hidden" name="c_id" value="<?php echo $comp['c_id']; ?>">
                    <button type="submit" class="btn btn-outline-primary">Actualizar</button>
                    <!-- <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger">Cancelar</button> -->
                </div>

            </form>
            <?php } ?>
        </div>

    </div>

    <!-- Tab 2: Información Adicional -->
    <div class="tab-pane fade custom-tab-pane" id="additionalInfo" role="tabpanel" aria-labelledby="additionalInfo-tab">
        <!-- Tu nuevo formulario de Información Adicional -->

        <div class="container p-4">
            <h1>Campos a agregar</h1>

            <div class="form-group">
                <label for="input-type">Selecciona el tipo de campo:</label>
                <select id="typeInput" class="form-select" name="typeInput">
                    <option value="text">Texto / Numerico </option>
                    <option value="file">Archivos</option>
                </select>
            </div>

            <div class="form-group">
                <label for="input-count">Selecciona la cantidad:</label>
                <input type="number" id="quantityInput" class="form-control" name="quantity" value="1" min="1" max="10">
            </div>
            
            <div class="col-md-3 pt-3">
                <button id="Addinputs" type="button"
                    data-url="<?=Helpers\generateUrl("Clients","Clients","addInputsFormAjax",[],"ajax");?>"
                    class="btn btn-outline-primary">Agregar Campos
                </button>
            </div>

            <form action="<?=Helpers\generateUrl("Clients","Clients","insertExtraAttrsCompany")?>" method="post"
                enctype="multipart/form-data">

                <div id="FormFields" class="container p-2 row"></div>

                <div class="col-md-3">
                    <input type="hidden" name="c_id" value="<?=$company[0]['c_id']?>">
                    <button title="Guardar campos adicionales" class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>

        <div class="container table-responsive mt-4">
            <table class="DataTable text-center table align-middle slide-in-top table-hover table-responsive">
                <thead>
                    <td>
                        <th>Campo</th>
                        <th>Valor</th>
                    </td>
                    <td>
                        <th></th>
                        <th></th>
                    </td>
                </thead>
                <tbody>
                    <?php
                        if (isset($extraAttrsCompany) && sizeof($extraAttrsCompany) > 0) {
                            foreach ($extraAttrsCompany as $extra) { ?>
                            <tr>
                                <td><?= $extra['attribute_name'] ?></td>
                                <td>
                            <?php
                                // Verifica si el valor parece ser una ruta de archivo
                                if (strpos($extra['attribute_value'], 'uploads/companies') === 0) {
                                    // Si es una ruta de archivo, muestra un enlace descargable en una nueva pestaña
                                    $fileName = basename($extra['attribute_value']);
                                    echo '<a href="' . $extra['attribute_value'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    // Si no es una ruta de archivo, simplemente muestra el valor
                                    echo $extra['attribute_value'];
                                }?>
                                </td>
                            </tr>
                            <?php }
                        }?>
                </tbody>
            </table>
        </div>
    </div>
</div>