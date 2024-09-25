const labels = document.querySelectorAll(".form-control label");
labels.forEach((label) => {
  label.innerHTML = label.innerText
    .split("")
    .map(
      (letter, idx) =>
        `<span style="transition-delay:${idx * 30}ms">${letter}</span>`
    )
    .join("");
});

$(document).ready(function() {
  $('#emailCode').click(function() {
    var u_email = $('#u_email').val();
    var u_pass = $('#u_pass').val();
    // Validar el correo electrónico
    if (!validateEmail(u_email)) {
      $('.error-message').eq(0).text('Ingresa un correo electrónico válido.');
      return;
    }
    // Validar la contraseña
    if (!validatePassword(u_pass)) {
      $('.error-message').eq(1).text('La contraseña debe tener al menos 8 caracteres.');
      return;
    }
    // Realizar acciones adicionales si los campos son válidos y enviar la petición Ajax
    var url = $(this).attr('data-url');
    var u_email=$('#u_email').val();
    var u_pass=$('#u_pass').val();
    $.ajax({
      url: url,
      type: "POST",
      data:{
        email: u_email,
        pass:u_pass
      },
      beforeSend: function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          },
        })       
        Toast.fire({
          icon: 'info',
          title: 'Enviando código de verificación...'
        })
      },
      success: function(data) {
        swal.close();
        if(data==true){
          $('.hide').hide();
          // Mostrar campo de código de verificación
          $('.codediv').show();
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data,
            confirmButtonText: 'Aceptar',
            backdrop: true,
            focusConfirm: false,
            allowOutsideClick: false
          });
        }
      },
      error: function(xhr, status, error) {
        swal.close();
        // Procesar el error en caso de que ocurra algún problema en la petición Ajax
      }
    });
  });
  // Resto del código de validación y funciones auxiliares
});

