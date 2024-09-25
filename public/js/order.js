$(document).ready(function () {
  // Función para agregar un producto
  $(document).on("click", "#agregar_producto", function () {
    $('#additionalCostsOrderInput').removeAttr('readonly');
    let url = $(this).attr("data-url");
    //console.log(url);
    $.ajax({
      url: url,
      type: "POST",
      success: function (datos) {
        $(".modal-body").html(datos);
        $("#exampleModalFullscreen").modal("show");
      }
    });
  });

  let cont = 0;
  var discountsOrder = []; // Array para almacenar los descuentos individuales 

  // Función para añadir artículos a la orden  
  $(document).on("click", "#addArticles", function (event) {

    cont++;
    let shopcar = $(".cart-counter").text(cont);
    let id_article = $(this).val();
    let url = $(this).attr("data-url");
    let quantity_articles = $(this).siblings("input").val();
    let existingDiscountProductIdIndex = discountsOrder.findIndex(item => item.productId === id_article);

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
        data: { id_article: id_article, quantity_articles: quantity_articles },
        success: function (response) {
          let totalSubtotal = 0;
          let iva = 0;

          $(".DataTable").DataTable().destroy();
          $("#contArticlesOrder").append(response);
          $(".DataTable").DataTable();

          $("#contArticlesOrder tr").each(function () {
            // Obtener el ID del producto para este artículo
            let productId = $(this).find(".ar_id_" + id_article).text().trim();
            //console.log("productId: ", productId);
            // Obtener el precio del artículo de esta fila
            let price = parseFloat($(this).find(".price").text().trim().replace(',', ''));
            //console.log("price: ", price);
            // Obtener la cantidad de productos para este artículo
            let quantity = parseFloat($(this).find(".quantityArt").val());

            // Obtener el valor del descuento aplicado
            let discountPriceValue = parseFloat($(this).find(".discount>input").val());
            let priceAfterDiscount = price - discountPriceValue;
            //console.log("Descuento aplicado:", priceAfterDiscount);
            // Verificar si los valores son números válidos y si el descuento aplicado es diferente de cero
            if (!isNaN(price) && !isNaN(priceAfterDiscount) && priceAfterDiscount !== 0) {
              // Verificar si el producto ya está en el array de descuentos
              let existingDiscountIndex = discountsOrder.findIndex(item => item.productId === productId);
              //console.log("existingDiscountIndex:", existingDiscountIndex);
              if (existingDiscountIndex !== -1) {
                // Si el producto ya tiene un descuento registrado, sumar el nuevo descuento al descuento existente
                discountsOrder[existingDiscountIndex].discount += priceAfterDiscount * quantity;
                //console.log("arrayModificado:", discountsOrder);
              } else {
                // Agregar el descuento total por artículo al array discountsOrder
                if (productId.trim() !== '') {
                  discountsOrder.push({
                    productId: productId,
                    discount: priceAfterDiscount * quantity
                  });
                }
                //console.log("arraySinModificado:", discountsOrder);
              }
            }
          });

          // Calcular el total del descuento general sumando todos los descuentos totales por artículo
          let totalDiscountGeneral = discountsOrder.reduce((acc, cur) => acc + cur.discount, 0);

          $("#contArticlesOrder .subtotal").each(function () {
            let subtotalValue = parseFloat($(this).text().replace("$", ""));
            totalSubtotal += subtotalValue;
          });

          iva = totalSubtotal * 0.19;
          total = iva + totalSubtotal;
          $("#subtotalOrder").text("$" + totalSubtotal.toFixed(2));
          $("#subtotalOrderInput").val(totalSubtotal.toFixed(2));
          $("#taxesOrder").text("$" + iva.toFixed(2));
          $("#taxesOrderInput").val(iva.toFixed(2));
          $("#discountOrder").text("$" + totalDiscountGeneral.toFixed(2));
          $("#discountOrderInput").val(totalDiscountGeneral.toFixed(2));
          $("#totalOrder").text("$" + total.toFixed(2));
          $("#totalOrderInput").val(total.toFixed(2));
          $("#totalOrderInputCurrent").val(total.toFixed(2));
        }
      });
    }
  });

  // Función para cambiar la cantidad de artículos
  $(document).on("change", ".quantityArt", function () {
    let totalSubtotal = 0;
    let changeInput = $(this).val();
    let priceUnit = +$(this)
      .closest("tr")
      .find(".discount")
      .text();
    let additionalCostsOrderInput = parseFloat($("#additionalCostsInput").val());
    let newsubtotal = priceUnit * changeInput;
    let subtotal = +$(this)
      .closest("tr")
      .find(".subtotal")
      .text("$" + parseInt(newsubtotal, 10));
    let iva = 0;

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
      let existingDiscountIndex = discountsOrder.findIndex(item => item.productId === productId);
      //console.log("existingDiscountIndex:", existingDiscountIndex);
      if (existingDiscountIndex !== -1) {
        // Si el producto ya tiene un descuento registrado, sumar el nuevo descuento al descuento existente
        discountsOrder[existingDiscountIndex].discount = priceAfterDiscount * quantity;
        //console.log("arrayModificado:", discountsOrder);
      } else {
        // Agregar el descuento total por artículo al array discountsOrder
        if (productId.trim() !== '') {
          discountsOrder.push({
            productId: productId,
            discount: priceAfterDiscount * quantity
          });
        }
        //console.log("arraySinModificado:", discountsOrder);
      }

    }

    // Calcular el total del descuento general sumando todos los descuentos totales por artículo
    let totalDiscountGeneral = discountsOrder.reduce((acc, cur) => acc + cur.discount, 0);

    $("#contArticlesOrder .subtotal").each(function () {
      let subtotalValue = parseFloat($(this).text().replace("$", ""));
      totalSubtotal += subtotalValue;
    });

    iva = totalSubtotal * 0.19;
    total = iva + totalSubtotal + additionalCostsOrderInput;
    $("#subtotalOrder").text("$" + totalSubtotal.toFixed(2));
    $("#subtotalOrderInput").val(totalSubtotal.toFixed(2));
    $("#taxesOrder").text("$" + iva.toFixed(2));
    $("#taxesOrderInput").val(iva.toFixed(2));
    $("#discountOrder").text("$" + totalDiscountGeneral.toFixed(2));
    $("#discountOrderInput").val(totalDiscountGeneral.toFixed(2));
    $("#totalOrder").text("$" + total.toFixed(2));
    $("#totalOrderInput").val(total.toFixed(2));
    $("#totalOrderInputCurrent").val(total.toFixed(2));
  });

  // funcion para activar los taxes de ordersincequote 
  if ($("#formOrderSinceQuote").length > 0) {
    // Este bloque de código se ejecutará solo si el formulario existe

    // Puedes realizar las operaciones que necesitas aquí, por ejemplo, actualizar los totales

    let additionalCostsQouteInput = parseFloat($("#additionalCostsOrderInput").val());
    additionalCostsQouteInput = isNaN(additionalCostsQouteInput) ? 0 : additionalCostsQouteInput;

    // Ejemplo de cómo actualizar los totales
    let totalSubtotal = 0;      

    $("#contArticlesOrder .subtotal").each(function () {
      let subtotalValue = parseFloat($(this).text().replace("$", ""));
      totalSubtotal += subtotalValue;
    });

    //Logica para manejar los descuentos
    $("#contArticlesOrder tr").each(function () {
      let id_article = parseInt($(this).find(".id_product").text());
      //console.log("id_article: ", id_article)
      // Obtener el ID del producto para este artículo          
      let productId = $(this).find(".ar_id_" + id_article).text().trim();
      //console.log("productId: ", productId);
      // Obtener el precio del artículo de esta fila
      let price = parseFloat($(this).find(".price").text().trim().replace(',', ''));
      //console.log("price: ", price);
      // Obtener la cantidad de productos para este artículo
      let quantity = parseFloat($(this).find(".quantityArt").val());

      // Obtener el valor del descuento aplicado
      let discountPriceValue = parseFloat($(this).find(".discount>input").val());
      let priceAfterDiscount = price - discountPriceValue;
      //console.log("Descuento aplicado:", priceAfterDiscount);
      // Verificar si los valores son números válidos y si el descuento aplicado es diferente de cero
      if (!isNaN(price) && !isNaN(priceAfterDiscount) && priceAfterDiscount !== 0) {
        // Verificar si el producto ya está en el array de descuentos
        let existingDiscountIndex = discountsOrder.findIndex(item => item.productId === productId);
        //console.log("existingDiscountIndex:", existingDiscountIndex);
        if (existingDiscountIndex !== -1) {
          // Si el producto ya tiene un descuento registrado, sumar el nuevo descuento al descuento existente
          discountsOrder[existingDiscountIndex].discount += priceAfterDiscount * quantity;
          //console.log("arrayModificado:", discountsOrder);
        } else {
          // Agregar el descuento total por artículo al array discountsOrder
          if (productId.trim() !== '') {
            discountsOrder.push({
              productId: productId,
              discount: priceAfterDiscount * quantity
            });
          }
          //console.log("arraySinModificado:", discountsOrder);
        }
      }
    });

    // Calcular el total del descuento general sumando todos los descuentos totales por artículo
    let totalDiscountGeneral = discountsOrder.reduce((acc, cur) => acc + cur.discount, 0);
    let iva   = totalSubtotal * 0.19;
    let total = iva + totalSubtotal + additionalCostsQouteInput;

    $("#subtotalOrder").text("$" + totalSubtotal.toFixed(2));
    $("#subtotalOrderInput").val(totalSubtotal.toFixed(2));
    $("#taxesOrder").text("$" + iva.toFixed(2));
    $("#taxesOrderInput").val(iva.toFixed(2));
    $("#discountOrder").text("$" + totalDiscountGeneral.toFixed(2));
    $("#discountOrderInput").val(totalDiscountGeneral.toFixed(2));
    $("#totalOrder").text("$" + total.toFixed(2));
    $("#totalOrderInput").val(total.toFixed(2));
    $("#totalOrderInputCurrent").val(total.toFixed(2));
  }

  // Función para eliminar una fila de la tabla
  $(document).on("click", ".delete-row", function () {
    cont--;
    let shopcar = $(".cart-counter").text(cont + " productos");
    let additionalCostsOrderInput = parseFloat($("#additionalCostsOrderInput").val());
    let deletedSubtotal = parseFloat(
      $(this)
        .closest("tr")
        .find(".subtotal")
        .text()
        .replace("$", "")
    );
    let totalSubtotal = parseFloat(
      $("#subtotalOrder")
        .text()
        .replace("$", "")
    );

    //Logica para manejar los descuentos
    let productIdToRemove = $(this).closest("tr").find("td").first().text().trim();
    // Encontrar el índice del producto en el array discountsOrder
    let indexToRemove = discountsOrder.findIndex(item => item.productId === productIdToRemove);
    //console.log("existingDiscountIndex:", existingDiscountIndex);
    if (indexToRemove !== -1) {
      // Calcular el descuento total a eliminar
      discountsOrder[indexToRemove].discount;
      // Eliminar el producto con su descuento del array
      discountsOrder.splice(indexToRemove, 1);
      console.log("Producto eliminado del array discountsOrder:", productIdToRemove);

    } else {
      console.log("El producto no se encontró en el array discountsOrder.");
    }

    // Recalcular el total del descuento general
    let totalDiscountGeneral = discountsOrder.reduce((acc, cur) => acc + cur.discount, 0);

    let iva = 0;
    let total = 0;

    totalSubtotal -= deletedSubtotal;
    iva = totalSubtotal * 0.19;
    total = iva + totalSubtotal + additionalCostsOrderInput;

    $("#subtotalOrder").text("$" + totalSubtotal.toFixed(2));
    $("#subtotalOrderInput").val(totalSubtotal.toFixed(2));
    $("#taxesOrder").text("$" + iva.toFixed(2));
    $("#taxesOrderInput").val(iva.toFixed(2));
    $("#totalOrder").text("$" + total.toFixed(2));
    $("#discountOrder").text("$" + totalDiscountGeneral.toFixed(2));
    $("#discountOrderInput").val(totalDiscountGeneral.toFixed(2));
    $("#totalOrderInput").val(total.toFixed(2));
    $("#totalOrderInputCurrent").val(total.toFixed(2));

    $(".DataTable").DataTable().destroy();
    $(this)
      .closest("tr")
      .remove();
    $(".DataTable").DataTable();
  });

  // Función para agregar un nuevo campo de entrada
  $(document).on("click", "#AddinputsOrder", function () {
    let url = $(this).attr("data-url");
    let type = $("#typeInput").val();
    let quantity = $("#quantityInput").val();
    $.ajax({
      type: "POST",
      url: url,
      data: { quantity: quantity, typeInput: type },
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "Campo agregado correctamente.",
          timer: 1000,
          showConfirmButton: false,
          position: "top",
          width: "15rem",
          padding: "0.5rem",
          background: "#fff",
          iconColor: "#1abc9c",
          toast: true
        });
        $("#FormFields").append(response);
      }
    });
  });

  // Función para eliminar un campo de entrada
  $(document).on("click", ".delete-btn", function () {
    $(this)
      .closest(".col-md-6")
      .remove();
  });

  // Función para abrir un PDF en un modal
  $(document).on("click", ".pdfModalLink", function () {
    let pdfUrl = $(this).data("url");
    let modalContent =
      '<iframe src="' + pdfUrl + '" width="100%" height="700px"></iframe>';

    // Actualiza el contenido de tu modal con el PDF
    $("#ModalContent").html(modalContent);

    // Abre la modal
    $("#ModalLarge").modal("show");
  });

  // Función para mostrar un modal de confirmación del documento de la orden
  $(document).on("click", ".ModalAcceptDocumentOrder", function () {
    let url = $(this).data("url");
    let order_id = $(this).data("id");
    let c_id = $(this).data("company");
    $.ajax({
      type: "POST",
      url: url,
      data: { order_id: order_id, c_id: c_id },
      success: function (response) {
        // Actualiza el contenido de tu modal con el PDF
        $("#ModalContent").html(response);

        // Abre la modal
        $("#ModalLarge").modal("show");
      }
    });
  });

  // Resto del código...
});

//Lógica para que cambie dinamicamente el campo Total de acuerdo al campo Gastos Adicionales
if (document.querySelector('#additionalCostsOrderInput')) {
  let inputAdditionCost = document.querySelector('#additionalCostsOrderInput');
  let totalOrder = document.querySelector('#totalOrder');
  let totalOrderInput = document.querySelector('#totalOrderInput');

  inputAdditionCost.addEventListener('input', () => {

    // Almacena el valor actual del input totalOrderInput
    let totalOrderInputCurrent = parseFloat(document.querySelector('#totalOrderInputCurrent').value);
    //console.log("totalOrderInputCurrent: ", totalOrderInputCurrent);
    // Obtenemos el valor ingresado en el campo de entrada y lo convertimos a un número
    let additionalCost = parseFloat(inputAdditionCost.value);
    // Verificamos si el valor ingresado está vacío
    if (inputAdditionCost.value.trim() === '') {
      totalOrder.textContent = '$' + totalOrderInputCurrent.toFixed(2); // Establecemos additionalCost en 0 si el valor está vacío     
      totalOrderInput.value = totalOrderInputCurrent; // Actualizamo
    }
    //console.log("additionalCost: ", additionalCost);
    //console.log("totalOrderInputCurrent: ", totalOrderInputCurrent);
    // Si additionalCost no es un número válido, dejamos el totalOrderInput como está
    if (!isNaN(additionalCost)) {
      // Realizamos la operación de suma con el otro valor
      let newValue = additionalCost + totalOrderInputCurrent;
      //console.log("newValue: ", newValue);
      // Formateamos el valor con un símbolo de dólar y dos decimales
      let formattedValue = '$' + newValue.toFixed(2);
      // Actualizamos el valor del input
      totalOrderInput.value = newValue;
      // Actualizamos el valor del otro elemento
      totalOrder.textContent = formattedValue;
      //console.log("totalOrderInput: ", totalOrderInput);
      //console.log("totalOrder: ", totalOrder);
    }
  });
}
