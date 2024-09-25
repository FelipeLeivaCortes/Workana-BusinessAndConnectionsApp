$(document).ready(function() {
    // Validar la coincidencia de contraseñas y la longitud en tiempo real
    $('#nueva_contraseña, #confirmar_contraseña').on('input', function() {
      var nuevaContraseña = $('#nueva_contraseña').val();
      var confirmarContraseña = $('#confirmar_contraseña').val();
  
      if (nuevaContraseña !== confirmarContraseña) {
        $('#confirmar_contraseña_error').text('Las contraseñas no coinciden');
      } else {
        $('#confirmar_contraseña_error').text('');
      }
  
      if (nuevaContraseña.length < 4 || nuevaContraseña.length > 12) {
        $('#nueva_contraseña_error').text('La contraseña debe tener entre 4 y 12 caracteres');
      } else {
        $('#nueva_contraseña_error').text('');
      }
    });
  
    // Validar el formulario al enviar
    $('#passwordForm').submit(function(event) {
      var contraseñaActual = $('#contraseña_actual').val();
      var nuevaContraseña = $('#nueva_contraseña').val();
      var confirmarContraseña = $('#confirmar_contraseña').val();
      var valid = true;
  
      if (contraseñaActual.length < 4 || contraseñaActual.length > 12) {
        $('#contraseña_actual_error').text('La contraseña actual debe tener entre 4 y 12 caracteres');
        valid = false;
      } else {
        $('#contraseña_actual_error').text('');
      }
  
      if (nuevaContraseña.length < 4 || nuevaContraseña.length > 12) {
        $('#nueva_contraseña_error').text('La nueva contraseña debe tener entre 4 y 12 caracteres');
        valid = false;
      } else {
        $('#nueva_contraseña_error').text('');
      }
  
      if (nuevaContraseña !== confirmarContraseña) {
        $('#confirmar_contraseña_error').text('Las contraseñas no coinciden');
        valid = false;
      } else {
        $('#confirmar_contraseña_error').text('');
      }
  
      if (!valid) {
        event.preventDefault(); // Evitar el envío del formulario
      }
    });
  });
  