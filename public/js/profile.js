$(document).ready(function() {
  // Escuchar el evento de cambio de archivo en el input file
  $('#fileInput').on('change', function() {
    var fileInput = $(this)[0];
    var file = fileInput.files[0];

    if (file) {
      var formData = new FormData();
      formData.append('photo', file);

      var url = $('.change-profile-picture').data('url');

      // Hacer la solicitud AJAX utilizando jQuery
      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          console.log('response');
            // Mostrar la alerta según el mensaje de la respuesta
            if (response == "success") {
              Swal.fire({
                icon: 'success',
                title: 'Imagen actualizada',
                text: 'La imagen se ha reemplazado correctamente.',
                confirmButtonText: 'Aceptar'
              }).then(function() {
                // Recargar la página para mostrar los cambios
                window.location.href = window.location.href;

              });
            } else if (response == "error") {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al reemplazar la imagen.',
                confirmButtonText: 'Aceptar'
              });
            } else if (response == "no_image") {
              Swal.fire({
                icon: 'info',
                title: 'No se recibió imagen',
                text: 'No se ha subido ninguna imagen.',
                confirmButtonText: 'Aceptar'
              });
            }
        },
        error: function(xhr, status, error) {
          // Manejo de errores en caso de que la solicitud falle
          console.error('Error al enviar la imagen:', error);
        }
      });
    }
  });
});