<form id="companyForm" action="<?= Helpers\generateUrl("Clients","Clients","RegisterCompaniesOnSeller",[],"ajax") ?>"
    method="POST">
    <div class="container">
        <h2>Selección de Empresas</h2>
        <div class="table-responsive">
            <table class="table DataTable table-hover slide-in-top  table-stripe">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre empresa</th>
                        <th scope="col">Descripción de empresa</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($companies as $c) {
                        echo '<tr>
                        <td>' . $c['c_id'] . '</td>
                        <td>' . $c['c_name'] . '</td>
                        <td>' . $c['c_desc'] . '</td>
                        <td class="text-center">
                        <button type="button" title="AddCompany" class="btn btn-outline-success btn-add-company"
                            data-company-id="' . $c['c_id'] . '" data-company-name="' . $c['c_name'] . '">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        </td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h4>Empresas seleccionadas:</h4>
        <ul id="selectedCompanies" class="list-group"></ul>
        <input type="hidden" id="selectedCompanyIds" name="selectedCompanyIds" value="">
        <input type="hidden" id="s_id" name="s_id" value="<?= $s_id?>">

        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Variable para almacenar las empresas seleccionadas
    var selectedCompanies = [];
    var selectedCompanyIds = [];

    // Evento al hacer clic en el botón de agregar empresa
    $(document).on('click', '.btn-add-company', function() {
        var companyId = $(this).data('company-id');
        var companyName = $(this).data('company-name');

        // Verificar si la empresa ya ha sido seleccionada
        if (selectedCompanies.includes(companyId)) {
            alert('La empresa ya ha sido seleccionada.');
        } else {
            selectedCompanies.push(companyId);
            selectedCompanyIds.push(companyId);

            // Mostrar la empresa seleccionada en la lista
            $('#selectedCompanies').append('<li class="list-group-item">' + companyName +
                '  <button type="button" class="btn btn-outline-danger btn-remove-company" data-company-id="' +
                companyId + '"><i class="fa-solid fa-trash"></i></button>' +
                '</li>');
        }

        // Actualizar el campo oculto con los c_id de las empresas seleccionadas
        $('#selectedCompanyIds').val(selectedCompanyIds.join(','));
    });

    // Evento al hacer clic en el botón de remover empresa
    $(document).on('click', '.btn-remove-company', function() {
        var companyId = $(this).data('company-id');

        // Eliminar la empresa de los arrays
        var index = selectedCompanies.indexOf(companyId);
        if (index !== -1) {
            selectedCompanies.splice(index, 1);
        }
        var idIndex = selectedCompanyIds.indexOf(companyId);
        if (idIndex !== -1) {
            selectedCompanyIds.splice(idIndex, 1);
        }

        // Remover la empresa de la lista
        $(this).closest('li').remove();

        // Actualizar el campo oculto con los c_id de las empresas seleccionadas
        $('#selectedCompanyIds').val(selectedCompanyIds.join(','));
    });
});


document.getElementById("companyForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar envío predeterminado del formulario

    // Realizar la solicitud AJAX aquí
    // Obtener los valores de los campos ocultos
    var selectedCompanyIds = $("#selectedCompanyIds").val();
    var s_id = $("#s_id").val();

    // Crear objeto de datos a enviar
    var data = {
        selectedCompanyIds: selectedCompanyIds,
        s_id: s_id
    };

    // Realizar la solicitud AJAX utilizando jQuery.ajax
    $.ajax({
        url: this.action,
        type: this.method,
        data: data,
        success: function(response) {
            console.log(response);
            // Manejar la respuesta de la solicitud AJAX
            $("#theadClientsOfSeller").html(response);
            // Realizar las actualizaciones necesarias en la tabla por AJAX
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Manejar errores de la solicitud AJAX
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });

});
</script>