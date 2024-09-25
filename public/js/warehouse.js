$(document).ready(function () {


    $(document).on('click', '.deleteWarehouse', function () {
        let urlDelete = $(this).data('url');
        let id = $(this).data('value');
        let card = $(this).closest('.card'); // seleccionar el div card más cercano
        $.ajax({
            type: "POST",
            url: urlDelete,
            data: { id: id },
            success: function (response) {
                response = response.trim();
                console.log(response);
    
                if (response === '0') {
                    // Mostrar un mensaje de alerta si la respuesta es 'None'
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se puede eliminar la bodega porque hay stock en ella'
                    });
                } else {
                    // Si la respuesta no es 'None', eliminar el div card
                    card.remove();
                }
            }
        });
    });
    

    $(document).on('click', '.buttonOpenWarehouse', function() {
        let url = $(this).data('url');
        let id = $(this).data('value');
    
        $.ajax({
            type: "POST",
            url: url,
            data: { id: id },
            success: function(response) {
                console.log(response);
               console.log(id);
               console.log(url);
               

                $("#ModalContent").html(response);
                $("#ModalLarge").modal("show");
            }
        });
    });

    
    $(document).on('change', '#departmentWarehouse', function() {
        let url = $(this).data('url');
        let depto = $(this).find('option:selected').text();
        console.log(depto);

        $.ajax({
            type: "POST",
            url: url,
            data: { depto: depto },
            success: function(response) {
                console.log(response);
                let divTowns = $('.divTowns').html(response);
            }
        });
    });
    

    $(document).on('change', '#departmentWarehouseUpdate', function() {
        let url = $(this).data('url');
        let depto = $(this).find('option:selected').text();
        console.log(depto);

        $.ajax({
            type: "POST",
            url: url,
            data: { depto: depto },
            success: function(response) {
                console.log(response);
                let divTowns = $('.divTownsUpdate').html(response);
            }
        });
    });


    $(document).on('click', '.buttonOpenWhArticles', function() {
        let url = $(this).data('url');
        $.ajax({
            type: "POST",
            url: url,
            success: function(response) {
                $(".modal-body").html("<h1 class='p-4 '>Articulos en la bodega</h1>"+response);
                $("#exampleModalFullscreen").modal("show");
                $(".DataTable").DataTable({
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
        });
    });



    // Función para manejar el clic en el botón
    function scrollToTop() {
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }

    // Espera hasta que el documento esté listo y luego selecciona el botón
    var scrollToTopBtn = $("#scrollToTopBtn");

    // Verifica si el botón se encontró antes de aplicar eventos
    if (scrollToTopBtn.length) {
        // Oculta el botón al principio
        scrollToTopBtn.hide();

        // Muestra u oculta el botón cuando el usuario se desplaza hacia abajo
        $(window).scroll(function() {
            if ($(this).scrollTop() > 0) {
                scrollToTopBtn.fadeIn();
            } else {
                scrollToTopBtn.fadeOut();
            }
        });

        // Aplica el evento clic al botón
        scrollToTopBtn.on("click", scrollToTop);
    }

});