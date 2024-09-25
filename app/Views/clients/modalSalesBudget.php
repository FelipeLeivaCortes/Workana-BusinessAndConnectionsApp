<div class="container">
    <h2 class="text-center">Presupuesto de Ventas del vendedor(mes)</h2>
    <h4 class="text-center">Buscar en un Rango de Fechas</h4>
    <input id="seller_id" type="hidden" value="<?= $s_id; ?>">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-group mt-2">
                <label for="date_start">Fecha de Inicio:</label>
                <input type="datetime-local" class="form-control" id="date_start">
            </div>
            <div class="form-group mt-2">
                <label for="date_end">Fecha de Fin:</label>
                <input type="datetime-local" class="form-control" id="date_end">
            </div>
            <button type="button" class="btn btn-primary mt-3" id="btnSearch" data-url="<?= Helpers\generateUrl("Clients", "Clients", "ConsultSalesBudgetSeller", [], "ajax") ?>">Buscar</button>
        </div>
    </div>


    <div id="results" class="mt-3">
        <!-- Aquí se mostrarán los resultados -->
    </div>

    <script>
        $(document).ready(function() {
            $("#btnSearch").click(function(e) {
                e.preventDefault();
                var date_start = $("#date_start").val();
                var date_end = $("#date_end").val();
                var seller_id = $("#seller_id").val();
                var url = $(this).attr("data-url");

                if (date_start == '' || date_end == '') {
                    Swal.fire({
                        title: "Atención!!",
                        text: "La fecha de inicio o la fecha fin no deben estar vacías",
                        icon: "error"
                    });
                    return false;
                } else {

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            date_start: date_start,
                            date_end: date_end,
                            seller_id: seller_id
                        },
                        success: function(response) {
                            let objData = JSON.parse(response);
                            if (objData.status) {

                                // Mostrar la respuesta (los resultados) en el div de resultados
                                var html = `<table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Presupuesto Asignado</th>
                                                        <th>Ventas Mes</th>
                                                        <th>Porcentaje(%)</th>                                                        
                                                        <th>Estado</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="text-center">
                                                    <td>${objData.data[0].b_budget}</td>
                                                    <td>${objData.data[0].total_order}</td>
                                                    <td>${objData.data[0].porcentaje}</td>
                                                    <td>${objData.data[0].b_state}</td>
                                                </tr>
                                                <tbody>
                                            </table>`;
                                $('#results').html(html);

                            } else {

                                Swal.fire({
                                    title: "Atención!!",
                                    text: objData.msg,
                                    icon: "warning"
                                });

                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Manejar errores de la solicitud AJAX
                            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                        }
                    });

                }
            });
        });
    </script>
</div>