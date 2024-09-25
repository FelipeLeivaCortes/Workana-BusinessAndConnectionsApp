<div class="container">
    <h1>Formulario de Registro de Compañía</h1>
    <form class="registerForm" action="<?php echo Helpers\generateUrl("Inbox", "Inbox", "processRegistrationRequest"); ?>" method="POST">
        <?php foreach ($company as $comp) { ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_name">Nombre de la compañía</label>
                        <label id="company_name" class="form-control" readonly><?php echo $comp['c_name']; ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="NIT">Número de identificación tributaria (NIT)</label>
                        <label id="NIT" class="form-control" readonly><?php echo $comp['c_num_nit']; ?></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="digVerNIT"># de Verificación</label>
                        <label id="digVerNIT" class="form-control" readonly><?php echo $comp['c_num_ver_nit']; ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="industry">Industria</label>
                        <?php foreach ($comp['Industry'] as $i) { ?>
                            <label id="industry" class="form-control" readonly><?php echo $i['industry_name']; ?></label>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country">País</label>
                        <label id="country" class="form-control" readonly><?php echo $comp['c_country']; ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="department">Departamento</label>
                        <label id="department" class="form-control" readonly><?php echo $comp['c_state']; ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city">Ciudad</label>
                        <label id="city" class="form-control" readonly><?php echo $comp['c_city']; ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representative_name">Nombre/s representante</label>
                        <?php foreach ($comp['representant'] as $rep) { ?>
                            <label id="representative_name" class="form-control" readonly><?php echo $rep['u_name']; ?></label>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representative_lastname">Apellido/s representante</label>
                        <?php foreach ($comp['representant'] as $rep) { ?>
                            <label id="representative_lastname" class="form-control" readonly><?php echo $rep['u_lastname']; ?></label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representative_document">Número de documento</label>
                        <?php foreach ($comp['representant'] as $rep) { ?>
                            <label id="representative_document" class="form-control" readonly><?php echo $rep['u_document']; ?></label>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representative_email">Correo electrónico</label>
                        <?php foreach ($comp['representant'] as $rep) { ?>
                            <label id="representative_email" class="form-control" readonly><?php echo $rep['u_email']; ?></label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representative_doc_type">Tipo de documento</label>
                        <?php foreach ($comp['representant'] as $rep) { ?>
                            <label id="representative_doc_type" class="form-control" readonly><?php echo $rep['u_type_document']; ?></label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="document_attachments">Documentos adjuntos</label>
                        <div class="row text-end">
                            <div class="col-md-6 ">
                                <label for="">RUT</label>
                                <button type="button" data-url="<?php echo $comp['c_route_rut']; ?>" class="btn btn-outline-dark btnModalDocumentRequest">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label for="">Representante legal</label>
                                <button type="button" data-url="<?php echo $comp['c_route_cc_representant']; ?>" class="btn btn-outline-dark btnModalDocumentRequest">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label for="">Cámara de comercio</label>
                                <button type="button" data-url="<?php echo $comp['c_chamber_commerce']; ?>" class="btn btn-outline-dark btnModalDocumentRequest">
                                    <i class="fa fa-eye"> </i>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label for="">Formulario de inscripción</label>
                                <button type="button" data-url="<?php echo $comp['c_form_inscription']; ?>" class="btn btn-outline-dark btnModalDocumentRequest">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label for="">Certificación bancaria</label>
                                <button type="button" data-url="<?php echo $comp['c_certificate_bank']; ?>" class="btn btn-outline-dark btnModalDocumentRequest">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                        </div>

                        <div class="container p-4">
                            <!-- Campo oculto para almacenar la opción seleccionada -->
                            <input type="hidden" class="opcion" name="rejectOrAccept" value="">
                            <?php foreach ($comp['representant'] as $rep) { ?>
                                <input type="hidden" name="u_id" value="<?php echo $rep['u_id']; ?>">
                            <?php } ?>
                            <input type="hidden" name="c_id" value="<?php echo $comp['c_id']; ?>">

                            <button type="button" class="btn btn-outline-primary sendFormRequest" data-opcion="accept">Aceptar
                                petición de registro</button>
                            <button type="button" class="btn btn-outline-danger sendFormRequest" data-opcion="reject">Denegar
                                petición de registro</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    </form>
</div>