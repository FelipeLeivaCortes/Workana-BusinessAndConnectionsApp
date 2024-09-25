$(document).ready(function() {
    // Escuchar el clic en el botón "Eliminar"
    $(".deleteCategory").click(function() {
        // Obtener el cat_id desde el atributo data
        var catId = $(this).data("catid");
        var url = $(this).data('url');

        // Mostrar una ventana emergente de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres eliminar esta categoría?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // El usuario confirmó la eliminación, realizar la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: url, // Reemplaza esto con la URL de tu script PHP para eliminar
                    data: { cat_id: catId }, // Enviar el cat_id como datos
                    success: function(response) {
                        // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                        Swal.fire('Eliminado', 'La categoría ha sido eliminada correctamente', 'success');
                        // Recargar la página después de 1 segundo (ajusta el tiempo según tus necesidades)
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si la solicitud AJAX falla
                        Swal.fire('Error', 'Hubo un error al eliminar la categoría: ' + error, 'error');
                    }
                });
            }
        });
    });

    $(".updateCategory").click(function() {
        // Obtener el cat_id desde el atributo data
        var catId = $(this).data("catid");
        var url = $(this).data('url');
 
        $.ajax({
            type: "POST",
            url: url, // Reemplaza esto con la URL de tu script PHP para eliminar
            data: { cat_id: catId }, // Enviar el cat_id como datos
            success: function(response) {
                // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                $("#ModalContent").html(response);
                $("#ModalLarge").modal("show");
            }
        });

    });






});
