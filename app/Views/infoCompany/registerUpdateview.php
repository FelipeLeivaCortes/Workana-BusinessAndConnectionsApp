<div class="container">
    <h1 class="text-center">Formulario de activacion</h1>
    <form id="registerUser"
        action='<?php echo Helpers\generateUrl("Company","Company","updateRegisterPreview",[],"ajax");?>' method="post"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_name">Nombre de la compañía</label>
                    <input name="company_name" id="company_name" type="text" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="document">Número de identificación tributaria (NIT)</label>
                    <input name="NIT" id="NIT" type="text" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="industry">Industria</label>
                    <select id="industry" name="industry" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <?php foreach ($industries as $key) {
                              echo "<option value=".$key['tpi_id'].">".$key['industry_name']."</option>";
                            }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="country">País</label>
                    <input name="country" id="country" readonly type="text" Value="Colombia"class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="department">Departamento</label>
                        <select data-url="<?php echo Helpers\generateUrl("Access","Access","TownsWithDepto",[],"ajax")?>" name="department" id="department" class="form-control">
                        <option value="" disabled selected>Seleccione una opción</option>
                            <?php foreach ($deptos as $dep) {
                              echo "<option value=".$dep['NOMBRE_DEPTO'].">".$dep['NOMBRE_DEPTO']."</option>";
                            }?>
                        </select>
                        

                    </div>
                </div>
                <div class="col-md-6 divTowns">
                    
                </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representative_name">Nombre/s representante</label>
                    <input name="representative_name" id="representative_name" type="text" class="form-control"
                        required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representative_lastname">Apellido/s representante</label>
                    <input name="representative_lastname" id="representative_lastname" type="text" class="form-control"
                        required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representative_document_type">Tipo de documento</label>
                    <select id="representative_document_type" name="representative_document_type" class="form-select"
                        required>
                        <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                            <option value="Cedula de ciudadanía">Cédula de ciudadanía</option>
                            <option value="Tarjeta de extranjería">Tarjeta de extranjería</option>
                            <option value="Cedula de extranjeria">Cédula de extranjería</option>
                            <option value="NIT">NIT</option>
                            <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representative_document">Número de documento</label>
                    <input name="representative_document" id="representative_document" type="text" class="form-control"
                        required>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Número de teléfono</label>
                    <input name="phone" id="phone" type="text" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rut">RUT</label>
                    <input name="rut" id="rut" type="file" class="form-control-file" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="chamber_of_commerce">Cámara de Comercio</label>
                    <input name="chamber_of_commerce" id="chamber_of_commerce" type="file" class="form-control-file"
                        required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representative_cedula">Cédula del representante legal</label>
                    <input name="representative_cedula" id="representative_cedula" type="file" class="form-control-file"
                        required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_inscription">Formulario de inscripcion</label>
                    <input name="form_inscription" id="form_inscription" type="file" class="form-control-file" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="certificate_bank">Certificacion bancaria</label>
                    <input name="certificate_bank" id="certificate_bank" type="file" class="form-control-file" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Descripción de la empresa</label>
                    <textarea name="c_desc" id="c_desc" class="form-control" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" value="<?=$_SESSION['IdCompany']?>" name="c_id">
            <input type="hidden" value="<?=$_SESSION['idUser']?>" name="u_id">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block" type="submit">Registrar</button>
            </div>
        </div>
    </form>
</div>