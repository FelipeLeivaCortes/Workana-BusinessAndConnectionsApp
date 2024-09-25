$(document).ready(function () {
    $(document).on('change', '#department', function() {
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

    
    $(document).ready(function() {
        // Función para validar un campo de archivo específico
        function validateFile(field, maxSize, allowedTypes) {
          var file = field.prop('files')[0];
    
          // Validación del tamaño máximo
          if (file && file.size > maxSize) {
            alert('El archivo debe ser menor o igual a 2MB.');
            field.val(''); // Limpia el campo de entrada
            return false;
          }
    
          // Validación del tipo de archivo
          if (file && !allowedTypes.includes(file.type)) {
            alert('El archivo debe ser un PDF, Word o Excel.');
            field.val('');
            return false;
          }
    
          return true;
        }
    
        // Evento change para cada campo de archivo
        $('#rut, #chamber_of_commerce, #representative_cedula, #form_inscription, #certificate_bank').change(function() {
          var field = $(this);
          var maxSize = 2097152; // Tamaño máximo permitido en bytes (2MB)
          var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    
          // Validar el campo de archivo
          validateFile(field, maxSize, allowedTypes);
        });
    
        // Evento submit del formulario
        $('#registerUser').submit(function() {
          var rutFile = $('#rut').prop('files')[0];
          var chamberFile = $('#chamber_of_commerce').prop('files')[0];
          var repCedulaFile = $('#representative_cedula').prop('files')[0];
          var formInscriptionFile = $('#form_inscription').prop('files')[0];
          var certificateBankFile = $('#certificate_bank').prop('files')[0];
    
          // Validación individual de cada campo de archivo
          if (!validateFile($('#rut'), maxSize, allowedTypes)) {
            return false; // Detiene el envío del formulario
          }
          if (!validateFile($('#chamber_of_commerce'), maxSize, allowedTypes)) {
            return false;
          }
          if (!validateFile($('#representative_cedula'), maxSize, allowedTypes)) {
            return false;
          }
          if (!validateFile($('#form_inscription'), maxSize, allowedTypes)) {
            return false;
          }
          if (!validateFile($('#certificate_bank'), maxSize, allowedTypes)) {
            return false;
          }
    
          // El formulario se enviará si pasa todas las validaciones
          return true;
        });
      });


});