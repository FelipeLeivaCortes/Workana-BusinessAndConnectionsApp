$(document).ready(function () {
  // Inicializa la tabla DataTable
  var table = $(".DataTable").DataTable({
    order: [[0, 'DESC']],
    responsive: true,
    orderCellsTop: true,
    fixedHeader: true,
    colReorder: true,
    resizer: true,
    autoWidth: false,
    scrollY: "250px", // Altura de la tabla
    scrollX: true, // Habilita el desplazamiento horizontal
    scrollCollapse: true,
    language: {
      decimal: "",
      emptyTable: "No hay datos",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(Filtro de _MAX_ registros Totales)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Numero de filas _MENU_",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron resultados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Proximo",
        previous: "Anterior",
      },
    },
  });

  $(".DataTable thead tr:eq(1) th").each(function (i) {
    var title = $(this).text();

    var containsImageOrButton = false;

    // Verifica si alguna fila del tbody de la columna contiene una imagen o un botón
    $(this)
      .parent()
      .parent()
      .parent()
      .find("tbody tr")
      .each(function () {
        if (
          $(this)
            .find("td:eq(" + i + ")")
            .find("img").length > 0 ||
          $(this)
            .find("td:eq(" + i + ")")
            .find("button").length > 0
        ) {
          containsImageOrButton = true;
          return false; // Sal del bucle una vez que encuentres una imagen o botón
        }
      });

    if (!containsImageOrButton) {
      // Agrega el campo de búsqueda solo si no contiene una imagen o un botón en ninguna fila del tbody
      $(this).html(
        '<input type="text" class="form-control" placeholder="' +
          "Buscar"+
          '" />'
      );
      $("input", this).on("keyup change", function () {
        // Realiza la búsqueda en la columna correspondiente cuando se cambia el valor del input
        if (table.column(i).search() !== this.value) {
          table.column(i).search(this.value).draw();
        }
      });
    }
  });

  // Habilita el redimensionamiento de columnas con el mouse
  $(".DataTable th").resizable({
    handles: "e,w", // Permite redimensionar desde el lado derecho (este) y el lado izquierdo (oeste)
    minWidth: 50, // Ancho mínimo de la columna
    stop: function (event, ui) {
      // Al detener el redimensionamiento, actualiza el ancho de la columna
      var columnIndex = $(this).index();
      var newWidth = ui.size.width;
      table.column(columnIndex).nodes().to$().css("width", newWidth);
      table.draw();
    },
  });
});
