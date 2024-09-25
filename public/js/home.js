$(document).ready(function () {
    // redirects views home
   $(document).on("click","#contIconUsers",function () {
        let url=$(this).attr("data-url");
        console.log(url);
        $.ajax({
            url: url,
            type: "POST",
            success: function(datos) {
                console.log(datos);
                $("#homecont").html(datos);
                var table = $('.DataTable').DataTable({
                    responsive: true,
                    orderCellsTop: true,
                    fixedHeader: true,
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
                    },
                });
            }
        });
   });
   $(document).on("click","#contIconAddress",function () {
        let url=$(this).attr("data-url");
        console.log(url);
        $.ajax({
            url: url,
            type: "POST",
            success: function(datos) {
                console.log(datos);
                $("#homecont").html(datos);
            }
        });
   });



  $(document).on("change", "#changeAddressCheck", function() {
    if($(this).is(":checked")) {
      let url = $(this).data('url');
      $.ajax({
        type: "POST",
        url: url,
        success: function(response) {
          $('#contBillingAddress').html(response);
          Swal.fire({
            icon: 'success',
            title: 'La Dirección de envió sera la misma que de la de facturación.',
            timer: 1000,
            showConfirmButton: false,
            position: 'top',
            width: '15rem',
            padding: '0.5rem',
            background: '#fff',
            iconColor: '#1abc9c',
            toast: true,
          });
             
          console.log(response);
        }
      });
    }
  });
  

   $(document).on("change",".addressBilling",function (e) {
    e.preventDefault(); // Previene el comportamiento predeterminado del botón de enviar
    var form = $(this).closest("form"); // Obtiene el formulario más cercano al botón de enviar
    var url = form.attr("action"); // Obtiene la URL del archivo que procesa el formulario
    var data = form.serialize(); // Obtiene los datos del formulario en formato de cadena
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
           // Mostrar una alerta de confirmación
        Swal.fire({
          icon: 'success',
          title: 'Dirección de facturación agregada correctamente',
          timer: 1000,
          showConfirmButton: false,
          position: 'top',
          width: '15rem',
          padding: '0.5rem',
          background: '#fff',
          iconColor: '#1abc9c',
          toast: true,
        });
            console.log(response); // Maneja la respuesta del servidor en caso de éxito
        },
        error: function (xhr, status, error) {
            console.log(error); // Maneja el error en caso de que la solicitud no sea exitosa
        }
    });
  });



   $(document).on("change",".addressShipping",function (e) {
    e.preventDefault(); // Previene el comportamiento predeterminado del botón de enviar
    var form = $(this).closest("form"); // Obtiene el formulario más cercano al botón de enviar
    var url = form.attr("action"); // Obtiene la URL del archivo que procesa el formulario
    var data = form.serialize(); // Obtiene los datos del formulario en formato de cadena
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
           // Mostrar una alerta de confirmación
        Swal.fire({
          icon: 'success',
          title: 'Dirección de envió agregada correctamente',
          timer: 1000,
          showConfirmButton: false,
          position: 'top',
          width: '15rem',
          padding: '0.5rem',
          background: '#fff',
          iconColor: '#1abc9c',
          toast: true,
        });
            console.log(response); // Maneja la respuesta del servidor en caso de éxito
        },
        error: function (xhr, status, error) {
            console.log(error); // Maneja el error en caso de que la solicitud no sea exitosa
        }
    });
  });

  ////update info user company
   $(document).on("click","#updateInfoUserForm",function (e) {
    e.preventDefault(); // Previene el comportamiento predeterminado del botón de enviar
    var form = $(this).closest("form"); // Obtiene el formulario más cercano al botón de enviar
    var url = form.attr("action"); // Obtiene la URL del archivo que procesa el formulario
    var data = form.serialize(); // Obtiene los datos del formulario en formato de cadena
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
           // Mostrar una alerta de confirmación
        Swal.fire({
          icon: 'success',
          title: 'Información actualizada correctamente!',
          timer: 1000,
          showConfirmButton: false,
          position: 'top',
          width: '15rem',
          padding: '0.5rem',
          background: '#fff',
          iconColor: '#1abc9c',
          toast: true,
        });
            console.log(response); // Maneja la respuesta del servidor en caso de éxito
        },
        error: function (xhr, status, error) {
            console.log(error); // Maneja el error en caso de que la solicitud no sea exitosa
        }
    });
  });
  ////update info user company
  $(document).on("click", "#updatePasswordButton", function (e) {
    e.preventDefault();
    var form = $(this).closest("form");
    var url = form.attr("action");
    var data = form.serialize();
    
    // Mostrar la ventana emergente de carga mientras se envía el correo de notificación
    Swal.fire({
      title: 'Enviando correo de notificación...',
      position: 'top',
      showConfirmButton: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });
  
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      success: function (response) {
        Swal.close(); // Cerrar la ventana emergente de carga
        if (response=='Las contraseñas no coinciden') {
          icon='error';
        }else{
          icon='success'
        }
        Swal.fire({
          icon: icon,
          title: response,
          timer: 1000,
          showConfirmButton: false,
          position: 'top',
          width: '15rem',
          padding: '0.5rem',
          background: '#fff',
          iconColor: '#1abc9c',
          toast: true,
        });
        console.log(response);
      },
      error: function (xhr, status, error) {
        Swal.close(); // Cerrar la ventana emergente de carga
        Swal.fire({
          icon: 'error',
          title: 'Error al actualizar la información',
          text: 'Por favor, inténtalo de nuevo más tarde.',
          position: 'top',
          showConfirmButton: false,
          timer: 3000,
          toast: true,
        });
      }
    });
  });
  


  

  //  //submit form register user
  $(document).on("click", "#RegisterUsersOfCompany", function (e) {
    e.preventDefault(); // Previene el comportamiento predeterminado del botón de enviar
    let form = $(this).closest("form");
    var url = form.attr("action"); // Obtiene la URL del archivo que procesa el formulario
    var data = form.serialize();

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
            // Mostrar una alerta de confirmación
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Información actualizada correctamente!',
            //     timer: 1000,
            //     showConfirmButton: false,
            //     position: 'top',
            //     width: '15rem',
            //     padding: '0.5rem',
            //     background: '#fff',
            //     iconColor: '#1abc9c',
            //     toast: true,
            // });

            // Pegar el contenido en el tbody
            $('#ListUsersOfCompany').html(response);

            // // Destruir la instancia existente de DataTable, si existe
            // var table = $('.DataTable').DataTable();
            // if (table !== undefined && $.isFunction(table.destroy)) {
            //     table.destroy();
            // }

            // // Inicializar DataTables nuevamente
            // $('.DataTable').DataTable({
            //     responsive: true,
            //     orderCellsTop: true,
            //     fixedHeader: true,
            //     language: {
            //         // Configuración del idioma
            //     }
            // });
        },
        error: function (xhr, status, error) {
            console.log(error); // Maneja el error en caso de que la solicitud no sea exitosa
        }
    });
});

$(document).on("click", "#updateStatusUser", function (e) {
  e.preventDefault();
  let form = $(this).closest("form");
  var url = form.attr("action");
  var data = form.serialize();

  var loadingToast = Swal.fire({
    title: 'Enviando correo de notificación...',
    position: 'top',
    showConfirmButton: false,
    onBeforeOpen: () => {
      Swal.showLoading();
    }
  });

  $.ajax({
    type: "POST",
    url: url,
    data: data,
    success: function (response) {
      console.log(response);
      loadingToast.close();

      Swal.fire({
        icon: 'success',
        title: 'Información actualizada correctamente!',
        timer: 3000,
        showConfirmButton: false,
        position: 'top',
        width: '15rem',
        padding: '0.5rem',
        background: '#fff',
        icon: 'success',
        iconColor: '#1abc9c',
        toast: true,
      });
    },
    error: function (xhr, status, error) {
      console.log(error);
      loadingToast.close();

      Swal.fire({
        icon: 'error',
        title: 'Error al enviar el correo',
        text: 'Por favor, inténtalo de nuevo más tarde.',
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        toast: true,
      });
    }
  });
});

   //modal home
   $(document).on("click",".editUserProfile",function () {
        let UserId =$(this).data('id');
        let url = $(this).attr('data-url');
        console.log(url);
        console.log(UserId);
        $.ajax({
            url: url,
            type: "POST",
            data:{id:UserId},
            success: function(datos) {  
                $("#ModalContent").html(datos);
                $("#ModalLarge").modal("show"); 
            }
        });


   })

   $(document).on("click",".passwordUser",function () {
        let UserId =$(this).data('id');
        let url = $(this).attr('data-url');
        console.log(url);
        console.log(UserId);
        $.ajax({
            url: url,
            type: "POST",
            data:{id:UserId},
            success: function(datos) {  
                $("#ModalContent").html(datos);
                $("#ModalLarge").modal("show"); 
            }
        });
   })
// END

$(document).on("click",".disableUser",function () {
  let UserId =$(this).data('id');
  let url = $(this).attr('data-url');
  console.log(url);
  console.log(UserId);
  $.ajax({
      url: url,
      type: "POST",
      data:{id:UserId},
      success: function(datos) {  
          $("#ModalContent").html(datos);
          $("#ModalLarge").modal("show"); 
      }
  });
})
// END


//views password
$(document).on('click', '#toggle-password', function() {
  var passwordField = document.getElementById('new-password');
  var passwordFieldType = passwordField.getAttribute('type');
  passwordField.setAttribute('type', passwordFieldType === 'password' ? 'text' : 'password');
});

$(document).on('click', '#toggle-confirm-password', function() {
  var confirmPasswordField = document.getElementById('confirm-password');
  var confirmPasswordFieldType = confirmPasswordField.getAttribute('type');
  confirmPasswordField.setAttribute('type', confirmPasswordFieldType === 'password' ? 'text' : 'password');
});
});








// GRAPHIC BARRAS QUOTES
var barChartElement = document.getElementById("myChart");
if (barChartElement) {
  var data = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    datasets: [],
  };

    var options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        yAxes: [
          {
            type: 'linear',
            ticks: {
              beginAtZero: true,
              stepSize: 1, 
              callback: function(value) {
                return parseInt(value); // Formatear el valor como entero
              }, 
            },
          },
        ],
      },
    };

    // Obtener los valores de los inputs por clase
    var quoteInputs = document.querySelectorAll('.quote-value');
    var quoteValues = Array(12).fill(0); // Inicializar un array de 12 elementos con ceros, uno para cada mes


    quoteInputs.forEach(function(input) {
      var monthIndex = parseInt(input.name.match(/\[([0-9]{2})\]/)[1]) - 1; // Obtener el índice del mes desde el nombre del input
      quoteValues[monthIndex] = parseInt(input.value); // Actualizar el valor en el mes correspondiente
    });
      // Ahora puedes utilizar quoteValues en tus datos de la gráfica
      data.datasets.push({
        label: "Cotizaciones",
        data: quoteValues,
        borderWidth: 1,
      });
    

      var ctx = barChartElement.getContext("2d");
      var myChart = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options,
      });

      
}

// GRAPHIC BARRAS ORDERS
var barChartElement2 = document.getElementById("myChart2");
if (barChartElement2) {
  var data = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    datasets: [],
  };
    var options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        yAxes: [
          {
            type: 'linear',
            ticks: {
              beginAtZero: true,
              stepSize: 1,
              callback: function(value) {
                return parseInt(value); // Formatear el valor como entero
              }, 
            },
          },
        ],
      },
    };
      // Obtener los valores de los inputs por clase
      var orderInputs = document.querySelectorAll('.order-value');
      var orderValues = Array(12).fill(0); // Inicializar un array de 12 elementos con ceros, uno para cada mes
      orderInputs.forEach(function(input) {
        var monthIndex = parseInt(input.name.match(/\[([0-9]{2})\]/)[1]) - 1; // Obtener el índice del mes desde el nombre del input
        orderValues[monthIndex] = parseInt(input.value); // Actualizar el valor en el mes correspondiente
      }); 
      
      data.datasets.push({
        label: "Pedidos",
        data: orderValues,
        backgroundColor: 'rgba(255, 0, 0, 0.5)', // Rojo (con transparencia)
        borderColor: 'rgba(255, 0, 0, 1)', // Borde rojo (sin transparencia)
        borderWidth: 1,
      });
   
      var ctx = barChartElement2.getContext("2d");
      var myChart = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options,
      });
}


// GRAPHIC CAKE
var LimitCredit = document.getElementById("LimitCredit");

var pieChartElement = document.getElementById("myPieChart");
if (pieChartElement) {
  var limitCreditValue = LimitCredit !== null && typeof LimitCredit.value !== 'undefined' ? LimitCredit.value : "0";
  var data = { 
    labels: ["Limite de crédito", "Cupo comprometido", "Balance"],
    datasets: [
      {
        label: "Mi dataset de ejemplo",
        data: [limitCreditValue, 2000000, 1500000],
        backgroundColor: ["#FF6384", "#FF9F40", "#FFCE56"], // Colores personalizados
        borderColor: "#fff",
        borderWidth: 1,
      },
    ],
  };

  var options = {
    responsive: true,
    maintainAspectRatio: false,
  };

  var ctx = pieChartElement.getContext("2d");
  var myPieChart = new Chart(ctx, {
    type: "pie",
    data: data,
    options: options,
  });
}


