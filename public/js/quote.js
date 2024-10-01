$(document).ready(function () {

  $(document).on("click", "#agregar_productoQuote", function () {
      let url   = $(this).attr("data-url");

      $.ajax({
          url: url,
          type: "POST",
          success: function (datos) {
              $(".modal-body").html(datos);
              $("#exampleModalFullscreen").modal("show");
    
              if ($.fn.DataTable.isDataTable('.DataTableModal')) {
                  $('.DataTableModal').DataTable().destroy();
              }
    
              $('.DataTableModal').DataTable({
                  paging: true,
                  searching: true,
                  ordering: true,
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
                  }
              });
          },
      });
  });






  let cont      = 0;
  let discounts = [];

  $(document).on("click", "#addArticleQuote", function (event) {
    cont++;

    let id_article                      = $(this).val();
    let url                             = $(this).attr("data-url");
    let quantity_articles               = $(this).siblings("input").val();
    let existingDiscountProductIdIndex  = discounts.findIndex(item => item.productId === id_article);

    if (parseInt(quantity_articles) < 1 || isNaN(parseInt(quantity_articles))) {
      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();
      
      return false;
    }

    if (existingDiscountProductIdIndex !== -1) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...El producto ya lo agregó, Cierre esta ventana de articulos y agreguelo desde la tabla en la columna cantidad.',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        customClass: {
          title: 'small-font' // Clase CSS personalizada para reducir el tamaño de la fuente del título
        }
      });

      event.preventDefault(); // Detener la ejecución predeterminada del evento
      event.stopPropagation(); // Detener la propagación del evento
      event.stopImmediatePropagation(); // Detener la propagación adicional del evento
      return false;

    } else {
      Swal.fire({
        icon: "success",
        title: "Articulo agregado correctamente",
        timer: 1000,
        showConfirmButton: false,
        position: "top",
        width: "15rem",
        padding: "0.5rem",
        background: "#fff",
        iconColor: "#1abc9c",
        toast: true
      });

      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_article: id_article,
          quantity_articles: quantity_articles
        },
        success: function (response) {
          let totalSubtotal = 0;
          let iva = 0;

          $('.cart-counter').text(cont);

          $("#tableViewCreateQuote").DataTable().destroy();

          $("#contArticlesQuote").append(response);

          $("#tableViewCreateQuote").DataTable({
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
            }
          });

          $("#contArticlesQuote tr").each(function () {
            let productId = $(this).find(".ar_id_" + id_article).text().trim();
            let price     = parseFloat($(this).find(".price").text().trim().replace(',', ''));
            let quantity  = parseFloat($(this).find(".quantityArt").val());

            let discountPriceValue = parseFloat($(this).find(".discount>input").val());
            let priceAfterDiscount = price - discountPriceValue;

            if (!isNaN(price) && !isNaN(priceAfterDiscount) && priceAfterDiscount !== 0) {
              let existingDiscountIndex = discounts.findIndex(item => item.productId === productId);
              
              if (existingDiscountIndex !== -1) {
                discounts[existingDiscountIndex].discount += priceAfterDiscount * quantity;

              } else {
                if (productId.trim() !== '') {
                  discounts.push({
                    productId: productId,
                    discount: priceAfterDiscount * quantity
                  });
                }
              }
            }
          });

          // Calcular el total del descuento general sumando todos los descuentos totales por artículo
          let totalDiscountGeneral = discounts.reduce((acc, cur) => acc + cur.discount, 0);


          $("#contArticlesQuote .subtotal").each(function () {
            let subtotalValue = parseFloat($(this).text().replace("$", ""));
            totalSubtotal += subtotalValue;
          });

          iva = totalSubtotal * 0.19;
          total = iva + totalSubtotal;

          $("#subtotalQuote").text("$" + totalSubtotal.toFixed(2));
          $("#subtotalQuoteInput").val(totalSubtotal.toFixed(2));
          $("#taxesQuote").text("$" + iva.toFixed(2));
          $("#taxesQuoteInput").val(iva.toFixed(2));
          $("#discountQuote").text("$" + totalDiscountGeneral.toFixed(2));
          $("#discountQuoteInput").val(totalDiscountGeneral.toFixed(2));
          $("#totalQuote").text("$" + total.toFixed(2));
          $("#totalQuoteInput").val(total.toFixed(2));
          $("#totalQuoteInputCurrent").val(total.toFixed(2));
        },
      });
    }
  });

  $(document).on("change", ".quantityArt", function () {
    let totalSubtotal = 0;
    let changeInput = $(this).val();
    let priceUnit = +$(this).closest("tr").find(".discount").text();
    let additionalCostsQouteInput = parseFloat($("#additionalCostsInput").val()); 
    let newsubtotal = priceUnit * changeInput;
    let subtotal = +$(this)
      .closest("tr")
      .find(".subtotal")
      .text("$" + parseInt(newsubtotal, 10));
    let iva = 0;
    $("#contArticlesQuote .subtotal").each(function () {
      let subtotalValue = parseFloat($(this).text().replace("$", ""));
      totalSubtotal += subtotalValue;
    });

    //Logica para manejar los descuentos
    let productId = $(this).closest("tr").find("td").first().text().trim();
    // Obtener el precio del artículo de esta fila
    let price = parseFloat($(this).closest("tr").find(".price").text().trim().replace(',', ''));
    //console.log("price: ", price); 
    // Obtener la cantidad de productos para este artículo
    let quantity = parseFloat($(this).closest("tr").find(".quantityArt").val());
    //console.log("quantity: ", quantity);
    //Obtener el valor del descuento aplicado
    let discountPriceValue = parseFloat($(this).closest("tr").find(".discount>input").val());
    let priceAfterDiscount = price - discountPriceValue;
    //console.log("Descuento aplicado:", priceAfterDiscount);
    // Verificar si los valores son números válidos y si el descuento aplicado es diferente de cero
    if (!isNaN(price) && !isNaN(priceAfterDiscount) && priceAfterDiscount !== 0) {
      // Verificar si el producto ya está en el array de descuentos
      let existingDiscountIndex = discounts.findIndex(item => item.productId === productId);
      //console.log("existingDiscountIndex:", existingDiscountIndex);
      if (existingDiscountIndex !== -1) {
        // Si el producto ya tiene un descuento registrado, sumar el nuevo descuento al descuento existente
        discounts[existingDiscountIndex].discount = priceAfterDiscount * quantity;
        //console.log("arrayModificado:", discounts);
      } else {
        // Agregar el descuento total por artículo al array discounts
        if (productId.trim() !== '') {
          discounts.push({
            productId: productId,
            discount: priceAfterDiscount * quantity
          });
        }
        //console.log("arraySinModificado:", discounts);
      }

    }

    // Calcular el total del descuento general sumando todos los descuentos totales por artículo
    let totalDiscountGeneral = discounts.reduce((acc, cur) => acc + cur.discount, 0);

    iva = totalSubtotal * 0.19;
    total = iva + totalSubtotal + additionalCostsQouteInput;
    $("#subtotalQuote").text("$" + totalSubtotal.toFixed(2));
    $("#subtotalQuoteInput").val(totalSubtotal.toFixed(2));
    $("#taxesQuote").text("$" + iva.toFixed(2));
    $("#taxesQuoteInput").val(iva.toFixed(2));
    $("#discountQuote").text("$" + totalDiscountGeneral.toFixed(2));
    $("#discountQuoteInput").val(totalDiscountGeneral.toFixed(2));
    $("#totalQuote").text("$" + total.toFixed(2));
    $("#totalQuoteInput").val(total.toFixed(2));
    $("#totalQuoteInputCurrent").val(total.toFixed(2));
  });

  $(document).on("click", ".delete-row", function () {
    cont--;

    let shopcar = $(".cart-counter").text(cont);

    let additionalCostsQouteInput = parseFloat($("#additionalCostsInput").val());
    let deletedSubtotal = parseFloat(
      $(this).closest("tr").find(".subtotal").text().replace("$", "")
    );

    let productIdToRemove = $(this).closest("tr").find("td").first().text().trim();
    // Encontrar el índice del producto en el array discounts
    let indexToRemove = discounts.findIndex(item => item.productId === productIdToRemove);
    //console.log("existingDiscountIndex:", existingDiscountIndex);
    if (indexToRemove !== -1) {
      // Calcular el descuento total a eliminar
      discounts[indexToRemove].discount;      
      // Eliminar el producto con su descuento del array
      discounts.splice(indexToRemove, 1);
      console.log("Producto eliminado del array discounts:", productIdToRemove);
      
    } else {
      console.log("El producto no se encontró en el array discounts.");
    }
    
    // Recalcular el total del descuento general
    let totalDiscountGeneral = discounts.reduce((acc, cur) => acc + cur.discount, 0);

    let totalSubtotal = parseFloat($("#subtotalQuote").text().replace("$", ""));

    let iva = 0;
    let total = 0;

    totalSubtotal -= deletedSubtotal;
    iva = totalSubtotal * 0.19;
    total = iva + totalSubtotal + additionalCostsQouteInput;

    $("#subtotalQuote").text("$" + totalSubtotal.toFixed(2));
    $("#subtotalQuoteInput").val(totalSubtotal.toFixed(2));
    $("#taxesQuote").text("$" + iva.toFixed(2));
    $("#taxesQuoteInput").val(iva.toFixed(2));
    $("#discountQuote").text("$" + totalDiscountGeneral.toFixed(2));
    $("#discountQuoteInput").val(totalDiscountGeneral.toFixed(2));
    $("#totalQuote").text("$" + total.toFixed(2));
    $("#totalQuoteInput").val(total.toFixed(2));
    $("#totalQuoteInputCurrent").val(total.toFixed(2));

    $("#tableViewCreateQuote").DataTable().destroy();

    $(this).closest("tr").remove();

    $("#tableViewCreateQuote").DataTable({
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
      }
    });

  });

  $(document).on("click", "#addFieldsForm", function () {
    let url = $(this).attr("data-url");
    $.ajax({
      type: "POST",
      url: url,
      success: function (response) {
        $("#ModalContent").html(response);
        $("#ModalLarge").modal("show");
      },
    });
  });
});


$(document).on("click", "#addQuouteValidity", function () {
  let url = $(this).attr("data-url");
  let data_title = $(this).attr("data-title");
  $.ajax({
    type: "POST",
    url: url,
    data: {
      data_title: data_title
    },
    success: function (response) {
      $("#modalDefault").modal("show");
      $(".modal-content-default").html(response);
      $(".modal-title-default").text(data_title);
    },
  });
});


if (document.querySelector('#additionalCostsInput')) {
  let inputAdditionCost = document.querySelector('#additionalCostsInput');
  let totalQuote = document.querySelector('#totalQuote');
  let totalQuoteInput = document.querySelector('#totalQuoteInput');

  inputAdditionCost.addEventListener('input', () => {

    // Almacena el valor actual del input totalQuoteInput
    let totalQuoteInputCurrent = parseFloat(document.querySelector('#totalQuoteInputCurrent').value);
    //console.log("totalQuoteInputCurrent: ", totalQuoteInputCurrent);
    // Obtenemos el valor ingresado en el campo de entrada y lo convertimos a un número
    let additionalCost = parseFloat(inputAdditionCost.value);
    // Verificamos si el valor ingresado está vacío
    if (inputAdditionCost.value.trim() === '') {
      totalQuote.textContent = '$' + totalQuoteInputCurrent.toFixed(2); // Establecemos additionalCost en 0 si el valor está vacío     
      totalQuoteInput.value = totalQuoteInputCurrent; // Actualizamo
    }
    //console.log("additionalCost: ", additionalCost);
    //console.log("totalQuoteInputCurrent: ", totalQuoteInputCurrent);
    // Si additionalCost no es un número válido, dejamos el totalQuoteInput como está
    if (!isNaN(additionalCost)) {
      // Realizamos la operación de suma con el otro valor
      let newValue = additionalCost + totalQuoteInputCurrent;
      //console.log("newValue: ", newValue);
      // Formateamos el valor con un símbolo de dólar y dos decimales
      let formattedValue = '$' + newValue.toFixed(2);
      // Actualizamos el valor del input
      totalQuoteInput.value = newValue;
      // Actualizamos el valor del otro elemento
      totalQuote.textContent = formattedValue;
      //console.log("totalQuoteInput: ", totalQuoteInput);
      //console.log("totalQuote: ", totalQuote);
    }
  });


  // Adjunta un manejador de eventos de envío al formulario con el ID 'formNewQuote'
  $('#formNewQuote').on('submit', function(event) {
    event.preventDefault();
    
    const objectRequired = [
      {'id': 'payment_method', 'message': 'El campo Método de pago es obligatorio', 'type': 'select'},
      {'id': 'contArticlesQuote', 'message': 'Se debe registrar al menos un artículo', 'type': 'table'},
    ];
    
    for (const object of objectRequired) {
      let trigger = false;

      switch (object.type) {
        case 'select':
          if ($(`#${object.id}`).val() == null || $(`#${object.id}`).val().trim() === '') {
            trigger = true;
          }

          break;

        case 'table':
          const rows = $(`#${object.id} tr`);  
        
          if (rows.length < 2) {
            const cells = rows.first().find('td');

            if (cells.length < 2) {
              trigger = true;
              break;
            }
          }

          break;
      }

      if (trigger) {
        Swal.fire({
          title: 'Información',
          text: object.message,
          icon: 'info',
          showCancelButton: false,
          confirmButtonText: 'Aceptar'
        });
        
        return false;
      }
    }
    
    this.submit();
  });
}