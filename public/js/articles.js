$(document).ready(function () {
    $(document).on("click",".btn-grid",function () {
        let url=$(this).attr("data-url");
        let order = new URLSearchParams(url).get("order"); // Obtiene el valor de "order" de la URL     
        $.ajax({
            url: url,
            type: "POST",
            success: function(datos) {
                if (order!=='table') {
                    $("#contArticles").html(datos); 
                }else{
                    $("#contArticles").html(datos); 
                    $('.DataTable').DataTable().destroy();
                    var table = $('.DataTable').DataTable({
                        responsive: true,
                        orderCellsTop: true,
                        fixedHeader: true,
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay datos",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                            "infoFiltered": "(Filtro de _MAX_ registros Totales)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Numero de filas _MENU_",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "No se encontraron resultados",
                            "paginate": {
                
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Proximo",
                                "previous": "Anterior"
                            }
                        },
                    });
                }
                
            }
        });


    });
})