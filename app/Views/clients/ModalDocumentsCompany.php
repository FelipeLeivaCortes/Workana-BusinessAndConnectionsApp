<div class="container">
    <div class="row text-center">
      <h1>Documentos adjuntos</h1>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="paper">
                        <div class="paper-preview">
                            <embed src="<?php echo $company[0]['c_route_rut']; ?>" type="application/pdf" width="100%"
                                height="100%">
                        </div>
                        <a href="<?php echo $company[0]['c_route_rut']; ?>" target="_blank" title="Visualizar Documentos"
                            class="eye btn btn-outline-dark"><i class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="paper">
                        <div class="paper-preview">
                            <embed src="<?php echo $company[0]['c_route_cc_representant']; ?>" type="application/pdf"
                                width="100%" height="100%">
                        </div>
                        <a href="<?php echo $company[0]['c_route_cc_representant']; ?>" target="_blank"
                            title="Visualizar Documentos" class="eye btn btn-outline-dark"><i
                                class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="paper">
                        <div class="paper-preview">
                            <embed src="<?php echo $company[0]['c_chamber_commerce']; ?>" type="application/pdf"
                                width="100%" height="100%">
                        </div>
                        <a href="<?php echo $company[0]['c_chamber_commerce']; ?>" target="_blank"
                            title="Visualizar Documentos" class="eye btn btn-outline-dark"><i
                                class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="paper">
                        <div class="paper-preview">
                            <embed src="<?php echo $company[0]['c_form_inscription']; ?>" type="application/pdf"
                                width="100%" height="100%">
                        </div>
                        <a href="<?php echo $company[0]['c_form_inscription']; ?>" target="_blank"
                            title="Visualizar Documentos" class="eye btn btn-outline-dark"><i
                                class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="paper">
                        <div class="paper-lines"></div>
                        <div class="paper-preview">
                            <embed src="<?php echo $company[0]['c_certificate_bank']; ?>" type="application/pdf"
                                width="100%" height="100%">
                        </div>
                        <a href="<?php echo $company[0]['c_certificate_bank']; ?>" target="_blank"
                            title="Visualizar Documentos" class="eye btn btn-outline-dark"><i
                                class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 mb-2">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
