$(document).on("input", "#credit_limit_input", function() {
    // Obtener el valor actual del campo de entrada
    var inputValue = $(this).val();

    // Eliminar todos los caracteres no numéricos, excepto el punto (.)
    var numericValue = inputValue.replace(/[^0-9.]/g, '');

    // Verificar si el valor es un número válido
    if (!isNaN(numericValue)) {
        // Formatear el número con comas y puntos
        var formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        // Actualizar el campo de entrada con el valor formateado
        $(this).val(formattedValue);
    } else {
        // Si el valor no es válido, eliminar el contenido no numérico
        $(this).val('');
    }

});


