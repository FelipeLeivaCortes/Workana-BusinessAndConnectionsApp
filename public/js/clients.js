$(document).ready(function() {

  $('.updateInfoCompany').click(function() {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
        $.ajax({
            url: url,
            type: "POST",
            data:{id:id},
            success: function(datos) {     
                    $("#ModalContent").html(datos); 
                    $("#ModalLarge").modal("show");  
                     // Desactivar la tabla DataTable si ya existe
                  if ($.fn.DataTable.isDataTable('.DataTable')) {
                    $('.DataTable').DataTable().destroy();
                }

                // Activar la tabla DataTable nuevamente
                $('.DataTable').DataTable({
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

  $('.updateStatusCompany').click(function() {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    let u_id=$(this).attr("data-user");
        console.log(url);
        console.log(id);
        $.ajax({
            url: url,
            type: "POST",
            data:{c_id:id,u_id:u_id},
            success: function(datos) {     
                    $("#ModalContent").html(datos); 
                    $("#ModalLarge").modal("show");              
            }
        });
  });

  $(document).on('click','.updateStatusClient', function () {
    let url = $(this).data('url');
    let id =$(this).data('id');

    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#ModalContent").html(response); 
        $("#ModalLarge").modal("show");   
      }
    });

  })

  $('.SubscriptionPlans').click(function() {
    let url=$(this).attr("data-url");
    let c_id=$(this).attr("data-id");
    let u_id=$(this).attr("data-user");
        console.log(url);
        console.log(c_id);
        $.ajax({
            url: url,
            type: "POST",
            data:{c_id:c_id,u_id:u_id},
            success: function(datos) {     
                    $("#ModalContent").html(datos); 
                    $("#ModalLarge").modal("show");              
            }
        });
  });
  
  $('.documentsCompany').click(function() {
    let url=$(this).attr("data-url");
    let c_id=$(this).attr("data-id");
        $.ajax({
            url: url,
            type: "POST",
            data:{c_id:c_id},
            success: function(datos) {     
                    $("#ModalContent").html(datos); 
                    $("#ModalLarge").modal("show");              
            }
        });
  });

  $(document).on('click','#createSeller, #CreateAsignButgetSeller',function () {
    let url=$(this).attr("data-url");
    //console.log("url: ",url);
    $.ajax({
      type: "POST",
      url: url,
      success: function (response) {
        console.log("url: ",url);
        console.log("response: ",response);
        $("#ModalContent").html(response); 
        $("#ModalLarge").modal("show");       
      }
    });
  })

  $(document).on('click','#CompanyAndSeller',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#ModalContent").html(response); 
        $("#ModalLarge").modal("show");       
      }
    });
  })

  $(document).on('click','#UpdateSeller',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#ModalContent").html(response); 
        $("#ModalLarge").modal("show");       
      }
    });
  })

  $(document).on('click','#SalesBudget',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#staticBody").html(response); 
        $("#staticBackdrop").modal("show");       
      }
    });
  })

  $(document).on('click','#addCompanyToSeller',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#staticBody").html(response); 
        $("#staticBackdrop").modal("show");       
      }
    });
  })
  
  $(document).on('click','.updateCreditLimit',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#staticBody").html(response); 
        $("#staticBackdrop").modal("show");       
      }
    });
  })

  $(document).on('click','.updateMethodsPay',function () {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#staticBody").html(response); 
        $("#staticBackdrop").modal("show");       
      }
    });
  })
  
  $(document).on('click','.createMethodsPay', function () {
    let url = $(this).data('url');
    let id =$(this).data('id');

    $.ajax({
      type: "POST",
      url: url,
      data:{id:id},
      success: function (response) {
        $("#ModalContent").html(response); 
        $("#ModalLarge").modal("show");   
      }
    });

  })

  $(document).on('click', '#deleteSellerOfCompany', function () {
    let url = $(this).data('url');
    let $row = $(this).closest('tr');
  
    // Mostrar confirmación al usuario con SweetAlert2
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¿Deseas borrar este vendedor asignado a la empresa?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, borrar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // El usuario confirmó la eliminación
        $.ajax({
          type: 'GET',
          url: url,
          success: function (response) {
            $row.remove();
  
            // Mostrar una alerta de éxito con SweetAlert2
            Swal.fire({
              icon: 'success',
              title: 'Vendedor eliminado',
              text: 'Este vendedor ya no está asignado a esta empresa.',
              showConfirmButton: false,
              timer: 2000 // La alerta se cerrará automáticamente después de 2 segundos
            });
          }
        });
      } else {
        // El usuario canceló la eliminación
        // No se realiza ninguna acción adicional
      }
    });
  });

  $('#emailForm').submit(function(event) {
      event.preventDefault(); // Detener el envío del formulario
      
      // Mostrar la alerta de envío con SweetAlert2
      Swal.fire({
          toast: true,
          position: 'top',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer);
              toast.addEventListener('mouseleave', Swal.resumeTimer);
          },
          icon: 'info',
          title: 'Enviando correo...'
      });

      // Enviar el formulario por AJAX
      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: $(this).serialize(),
      }).then(function(response) {
          // Mostrar la alerta de correo enviado con SweetAlert2
          Swal.fire({
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 1000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer);
                  toast.addEventListener('mouseleave', Swal.resumeTimer);
              },
              icon: 'success',
              title: 'El correo se ha enviado correctamente.'
          }).then(function() {
              // Redireccionar después de cerrar la alerta
              window.location.href = window.location.href;
          });
      }).catch(function() {
          // Mostrar la alerta de error con SweetAlert2
          Swal.fire({
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 1000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer);
                  toast.addEventListener('mouseleave', Swal.resumeTimer);
              },
              icon: 'error',
              title: 'Error al enviar el correo.'
          }).then(function() {
              // Redireccionar después de cerrar la alerta
              window.location.href = window.location.href;
          });
      });
  });

  $(document).ready(function() {
    $('#plan').change(function() {
        updateDates($(this).val());
    });

    function updateDates(plan) {
        const fechaInicioInput = $('#fecha_inicio');
        const fechaFinInput = $('#fecha_fin');
        const today = new Date();
        const selectedPlan = parseInt(plan);
        let fechaFin = new Date();

        if (selectedPlan === 3) {
            fechaFin.setMonth(today.getMonth() + 3);
        } else if (selectedPlan === 6) {
            fechaFin.setMonth(today.getMonth() + 6);
        } else if (selectedPlan === 12) {
            fechaFin.setMonth(today.getMonth() + 12);
        }

        fechaInicioInput.val(formatDate(today));
        fechaFinInput.val(formatDate(fechaFin));
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const day = date.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
  });

  $(document).ready(function() {
    // Tu código jQuery aquí
    // Escuchar el clic en el botón "Agregar Método de Pago"
    $(document).on("click", "#addMethodsPayButton", function() {
      // Obtener el formulario
      var form = $("#addMethodsPay");
  
      // Realizar la solicitud AJAX
      $.ajax({
          type: form.attr('method'), // Obtener el método del formulario (POST)
          url: form.attr('action'), // Obtener la URL del formulario desde el atributo "action"
          data: form.serialize(), // Serializar los datos del formulario
          success: function(response) {
            response = response.trim();
              // Manejar la respuesta del servidor
              // console.log(response);
              if (response === 'already') {
                  // Mostrar una alerta de éxito si la respuesta es 'already'
                  // Mostrar una alerta indicando que el método de pago ya existe
                  Swal.fire({
                    title: 'Error',
                    text: 'El método de pago ya existe.',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    customContainerClass: {
                        zIndex: 9999 // Establece el z-index directamente aquí
                    }
                });
              } else {               
                  Swal.fire({
                    title: '¡Éxito!',
                    text: 'Se ha agregado un nuevo método de pago.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                    customContainerClass: {
                        zIndex: 9999 // Establece el z-index directamente aquí
                    }
                  
                });
                $("#contMethodsPay").html(response);
              }
            
          },
          error: function(xhr, status, error) {
              // Manejar errores si la solicitud AJAX falla
              console.error(error);
          }
      });
    });


  });

  // add fields companies
  $(document).on('click','#Addinputs', function () {
    let url=$(this).attr('data-url');
    let type=$('#typeInput').val();
    let quantity=$('#quantityInput').val();
    $.ajax({
      type: "POST",
      url: url,
      data:{ 'quantity':quantity,'typeInput':type},
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Campo agregado correctamente.',
          timer: 1000,
          showConfirmButton: false,
          position: 'top',
          width: '15rem',
          padding: '0.5rem',
          background: '#fff',
          iconColor: '#1abc9c',
          toast: true,
        });
        $('#FormFields').append(response);
      }
    });
  })
  // delete input
  $(document).on('click', '.delete-btn', function() {
    $(this).closest('.col-md-6').remove();
  });

  /**
   * Copia los datos de los campos del Cliente a los campos de Entrega cuando se marca la casilla de verificación.
   */
  $(document).on('click', '#useClientDataCheckbox', function() {
    // Verifica si la casilla de verificación está marcada
    if ($(this).prop('checked')) {

      // Array de IDs para los campos del cliente
      const clientFieldIds = [
        'c_street',
        'c_apartament',
        'c_country',
        'c_state',
        'c_city',
        'c_postal_code'
      ];
      
      // Array de IDs para los campos correspondientes de entrega
      const deliveryFieldIds = [
        'c_shippingStreet',
        'c_shippingApartament',
        'c_shippingCountry',
        'c_shippingState',
        'c_shippingCity',
        'c_shippingPostalcode'
      ];
      
      // Recorre cada campo y copia el valor del cliente al de entrega
      clientFieldIds.forEach((clientId, index) => {
        const deliveryId = deliveryFieldIds[index];
        $(`#${deliveryId}`).val($(`#${clientId}`).val());
      });
    }
  });
});