$(document).on("change",'#DateTodayOrder',function () {
    if ($(this).is(':checked')) {
        // Si el checkbox está marcado, establecer la fecha de hoy
        var today = new Date().toISOString().split('T')[0];
        $('#pedidos-fecha-fin').val(today);
    } else {
        $('#pedidos-fecha-fin').val('');
    }
});
$(document).on("change",'#DateTodayQuote',function () {
    if ($(this).is(':checked')) {
        // Si el checkbox está marcado, establecer la fecha de hoy
        var today = new Date().toISOString().split('T')[0];
        $('#cotizacion-fecha-fin').val(today);
    } else {
        $('#cotizacion-fecha-fin').val('');
    }
});