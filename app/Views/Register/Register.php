<?php
    use function Helpers\generateUrl;
    include_once '../config/helpers.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Empresas</title>
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/register.css" rel="stylesheet">
    <link href="css/mobile/register.mobile.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/fortawesome/font-awesome/css/all.min.css">
</head>

<body>
    <div class="margintop">

    </div>
    <div id="backImg"></div>

    <div class="container" style="background: none; border: none;">
        <div class="card pt-5">
            <div class="card-body mt-5">
                <div id="titlteRegisterTop">
                    <div id="circle-title">
                    <i class="fa-solid fa-building" ></i>
                    </div>
                    <h1 class="text-center">Registro de Empresas</h1>
                </div>
                <form id="registerUser" action='<?php echo generateUrl("Access","Access","CompanyRequestRegister",[],"ajax");?>'
                    method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">Nombre de la compañía</label>
                                <input name="company_name" id="company_name" type="text" class="form-control mt-4" required>
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
                            </div>
                        </div>
        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="document">Número de identificación tributaria (NIT)</label>
                                <input  name="NIT" id="NIT" type="text" class="form-control mt-4" required>
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
        
                            </div>
                        </div>
        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="numVerNIT">Dígito de Verificación</label>
                                <input  name="numVerNIT" id="numVerNIT" type="number" class="form-control" min="0" required>
                                <p class="error"><small>El # verificacion solo puede contener números.</small></p>
        
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
                                <input name="country" id="country" type="text" class="form-control" value="Colombia" readonly>
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Departamento</label>
                                <select
                                    data-url="<?php echo Helpers\generateUrl("Access","Access","TownsWithDepto",[],"ajax")?>"
                                    name="department" id="department" class="form-control">
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
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
        
                            </div>
        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="representative_lastname">Apellido/s representante</label>
                                <input name="representative_lastname" id="representative_lastname" type="text"
                                    class="form-control" required>
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
        
                            </div>
        
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="representative_document_type">Tipo de documento</label>
                                <select id="representative_document_type" name="representative_document_type"
                                    class="form-control" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                                    <option value="Cedula de ciudadania">Cédula de ciudadanía</option>
                                    <option value="Tarjeta de extranjeria">Tarjeta de extranjería</option>
                                    <option value="Cedula de extranjeria">Cédula de extranjería</option>
                                    <option value="NIT">NIT</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="representative_document">Número de documento</label>
                                <input name="representative_document" id="representative_document" type="text"
                                    class="form-control" required>
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
        
                            </div>
        
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input name="email" id="email" type="text" class="form-control" required>
        
                                <p class="error"><small>El nombre solo puede contener letras.</small></p>
                            </div>
        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Número de teléfono</label>
                                <input name="phone" id="phone" type="text" class="form-control" required>
                                <p class="error"><small>El nombre solo puede contener letras.</small>
        
                            </div>
        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="contPass">
                                <label for="password">Contraseña</label>
                                <input name="password" id="password" type="password" class="form-control" required>
                                <p class="error"><small>La contraseña debe ser de 4 a 12 digitos.</small></p>
        
                            </div>
        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="contPass2">
                                <label for="confirm_password">Confirmar contraseña</label>
                                <input name="confirm_password" id="confirm_password" type="password" class="form-control"
                                    required>
        
                                    <p class="error"><small>Las contraseñas deben ser identicas</small></p>
                            </div>
        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rut">RUT (máx. 2MB, PDF, Word, Excel)</label>
                                <input name="rut" id="rut" type="file" class="form-control-file"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" size="2097152" required>
                                <p class="error"><small>El archivo debe ser un PDF, Word o Excel de tamaño máximo 2MB.</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="chamber_of_commerce">Cámara de Comercio (máx. 2MB, PDF, Word, Excel)</label>
                                <input name="chamber_of_commerce" id="chamber_of_commerce" type="file" class="form-control-file"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" size="2097152" required>
                                <p class="error"><small>El archivo debe ser un PDF, Word o Excel de tamaño máximo 2MB.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="representative_cedula">Cédula del representante legal (máx. 2MB, PDF, Word,
                                    Excel)</label>
                                <input name="representative_cedula" id="representative_cedula" type="file"
                                    class="form-control-file" accept=".pdf,.doc,.docx,.xls,.xlsx" size="2097152" required>
                                <p class="error"><small>El archivo debe ser un PDF, Word o Excel de tamaño máximo 2MB.</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_inscription">Formulario de inscripción (máx. 2MB, PDF, Word, Excel)</label>
                                <input name="form_inscription" id="form_inscription" type="file" class="form-control-file"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" size="2097152" required>
                                <p class="error"><small>El archivo debe ser un PDF, Word o Excel de tamaño máximo 2MB.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="certificate_bank">Certificación bancaria (máx. 2MB, PDF, Word, Excel)</label>
                                <input name="certificate_bank" id="certificate_bank" type="file" class="form-control-file"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx" size="2097152" required>
                                <p class="error"><small>El archivo debe ser un PDF, Word o Excel de tamaño máximo 2MB.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" id="buttonSendForm">
                            <button class="btn btn-primary btn-block" type="submit">Enviar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center mt-3">
                            <p class="text">¿Ya tienes una cuenta? <a href="login.php">Inicio de sesión</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="marginbottom">
        <p>Copyright businessandconnection.com</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../public/js/register.js"></script>
    <script src="../public/js/validation/validationRegister.js"></script>
</body>

</html>
