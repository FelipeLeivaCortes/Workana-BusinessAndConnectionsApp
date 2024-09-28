
<div class="container p-2">
    <form id="formUpdateDateQouteValidity" action="" method="post">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="selectIdCompanies">Empresa:</label>
                    <select id="selectIdCompanies" class="form-select" name="selectIdCompanies">
                        <option value="text" selected disabled>Seleccione una opción</option>

                        <?php foreach ($companies as $company) { ?>
                            <option value="<?= $company['c_id'] ?>"><?= $company['c_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mt-2">
                    <label for="dateQuoteValidity">Fecha de Vigencia Cotización:</label>
                    <input type="datetime-local" class="form-control" id="dateQuoteValidity" name="dateQuoteValidity">
                </div>
            </div>

            <div class="modal-footer mt-2">
                <button id="addQuoteValidity" type="submit" class="btn btn-primary send"
                    data-url="<?= Helpers\generateUrl("Quote", "Quote", "updateDateQuoteValiditytoCompany", [], "ajax"); ?>">
                    Agregar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#addQuoteValidity").click(function(e) {
          e.preventDefault();
          
          let selectIdCompanies           = $("#selectIdCompanies").val();
          let dateQuoteValidity           = $("#dateQuoteValidity").val();
          let url                         = $(this).attr("data-url");
          let formUpdateDateQouteValidity = $("formUpdateDateQouteValidity");
          let urlRedirect                 = "<?= Helpers\generateUrl("Quote", "Quote", "quotesCompanies"); ?>"


          console.log(selectIdCompanies);

          // EMPRESA DEBE ESTAR SELECCIONADA
          if (selectIdCompanies == '' || selectIdCompanies === null) {
              Swal.fire({
                title: "Atención!!",
                text: "Debe seleccionar un nombre de empresa",
                icon: "error"
              });

              return false;
          }

          // LA FECHA DEBE ESTAR INGRESADA
          if (dateQuoteValidity == '') {
              Swal.fire({
                title: "Atención!!",
                text: "Debe seleccionar una fecha de vigencia",
                icon: "error"
              });

              return false;
          }

          // LA FECHA DE VIGENCIA NO PUEDE SER ANTERIOR A LA FECHA ACTUAL
          const inputDate   = new Date(dateQuoteValidity);
          const currentDate = new Date();

          if (inputDate < currentDate) {
              Swal.fire({
                  title: "Atención!!",
                  text: "La fecha de vigencia no puede ser anterior a la fecha actual",
                  icon: "error"
              });

              return false;
          }
      
          $.ajax({
            url:  url,
            type: "POST",
            data: {
              selectIdCompanies: selectIdCompanies,
              dateQuoteValidity: dateQuoteValidity
            },
            success: function(response) {
              let objData = JSON.parse(response);

              if (objData.status) {
                $('#modalDefault').modal("hide");

                Swal.fire({
                  title: "Éxito!!",
                  text: objData.msg,
                  icon: "success"

                }).then((result) => {
                  window.location.href = urlRedirect;
                });

              } else {
                $('#modalDefault').modal("hide");

                Swal.fire({
                  title: "Atención!!",
                  text: objData.msg,
                  icon: "warning"

                }).then((result) => {
                  window.location.href = urlRedirect;
                });

              }

            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error("Error en la solicitud AJAX:", jqXHR, textStatus, errorThrown);
            }
          });

        });
    });
</script>
