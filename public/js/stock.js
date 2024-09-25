$(document).ready(function () {
  
  $(document).ready(function() {
    $(document).on('click', '#StockArticle', function() {
      let url = $(this).attr('data-url');
      $.ajax({
        type: "POST",
        url: url,
        success: function(response) {
          $('#ModalLarge').modal('show');
          $('#ModalContent').html(response);
  
          var $textarea = $("#textarea-list");
          var $list = $("#list");
          var $hiddenField = $("input[name='ar_characteristics']"); // Campo oculto en el formulario
  
          $textarea.on("input", function() {
            $list.html("");
            var lines = $textarea.val().split("\n");
            for (var i = 0; i < lines.length; i++) {
              var $li = $("<li></li>");
              $li.text(lines[i]);
              $list.append($li);
            }
            $hiddenField.val(lines.join(";")); // Asignar el valor al campo oculto
          });


          // modal of create a article in stock
          var checkbox = document.getElementById('date_expiration_checkbox');
          var dateInput = document.getElementById('stock_expiration_date_input');

          checkbox.addEventListener('change', function() {
              if (this.checked) {
                  dateInput.disabled = false;
              } else {
                  dateInput.disabled = true;
                  dateInput.value = ''; // Borra el valor del input
              }
          });


          const selectElement = document.getElementById('unidad-medida');
          const inputDiv = document.getElementById('input-div');
          const inputValue = document.getElementById('input-value');

          selectElement.addEventListener('change', function() {
              if (selectElement.value == '8') {
                  inputDiv.style.display = 'none';  // Ocultar el div si se selecciona 'Unidad'
                  inputValue.value = 'null';  // Establecer el valor 'null' en el input
              } else {
                  inputDiv.style.display = 'block';  // Mostrar el div para cualquier otra opción seleccionada
                  inputValue.value = '';  // Borrar el valor del input
              }
          });




        }
      });
    });
  });
  


    $(document).on('click','.viewArticle',function () {
        let url =$(this).data('url');
        let id=$(this).data('value');
        $.ajax({
          type: "POST",
          url: url,
          data:{id:id},
          success: function (response) {
            $('#ModalLarge').modal('show');
            $('#ModalContent').html(response);
            
          }
        });
    })
    $(document).on('change','#category',function () {
      var newValue = $(this).val(); 
    // Verificar si se ha seleccionado algo
        if(newValue != ''){
          let url =$(this).data('url');
          let id=$(this).val();
          $.ajax({
            type: "POST",
            url: url,
            data:{id:id},
            success: function (response) {
              $('#containerSub').html(response);
            }
          });
        }
            
    })
    $(document).on('click','.subcatView',function () {
          let url =$(this).data('url');
          let id=$(this).data('id');
          $.ajax({
            type: "POST",
            url: url,
            data:{id:id},
            success: function (response) {
              $('#ModalLarge').modal('show');
              $('#ModalContent').html(response);
            }
          });          
    })

$(document).on('click','#pdf-btn',function () {
         let pdfUrl = $(this).data('pdf-url');
        let modalContent = '<iframe src="' + pdfUrl + '" width="100%" height="700px"></iframe>';
        // Actualiza el contenido de tu modal con el PDF
        $('#ModalContent').html(modalContent);
        // Abre la modal
        $('#ModalLarge').modal('show');
      });


$(document).on('click','#editLisPrice',function () {
        let url = $(this).data('url');
        let id = $(this).data('id');
        $.ajax({
          type: "POST",
          url: url,
          data:{id:id},
          success: function (response) {
                  // Actualiza el contenido de tu modal con el PDF
            $('#ModalContent').html(response);
            // Abre la modal
            $('#ModalLarge').modal('show');
          }
        });
});
$(document).on('click','#editArticleOfStock',function () {
        let url = $(this).data('url');
        let id = $(this).data('id');
        $.ajax({
          type: "POST",
          url: url,
          data:{ar_id:id},
          success: function (response) {
                  // Actualiza el contenido de tu modal con el PDF
            $('#ModalContent').html(response);
            // Abre la modal
            $('#ModalLarge').modal('show');
            var $textarea = $("#textarea-list");
            var $list = $("#list");
            var $hiddenField = $("input[name='ar_characteristics']"); // Campo oculto en el formulario
    
            $textarea.on("input", function() {
              $list.html("");
              var lines = $textarea.val().split("\n");
              for (var i = 0; i < lines.length; i++) {
                var $li = $("<li></li>");
                $li.text(lines[i]);
                $list.append($li);
              }
              $hiddenField.val(lines.join(";")); // Asignar el valor al campo oculto
            });

            ///hide input value
                $('#unidad-medida').change(function() {
                  var selectedValue = $(this).val();
                   // El valor que deseas asignar al campo #input-value en caso de que no sea 8        
                  if (selectedValue == 8) {
                    $('#input-value').val('').prop('disabled', true);
                   
                  } else {
                      $('#input-div').show();
                      $('#input-value').val(valueQuantity).prop('disabled', false);
                  }
              });
          // dissabled date expiration
          $('#date_expiration_checkbox').change(function() {
            if ($(this).is(':checked')) {
              $('#stock_expiration_date_input').prop('disabled', false).val(stockExpirationDate);
            } else {
                $('#stock_expiration_date_input').prop('disabled', true).val('');
            }
        });




          }
        });
});

// validations inputs modal article update

$(document).on('change', '#imageInput', function() {
  var file = this.files[0];
  var fileType = file.type;
  var validImageTypes = ["image/jpeg", "image/png", "image/gif"];

  if (!validImageTypes.includes(fileType)) {
    $('#imageError').text('Solo se permiten archivos de imagen (JPEG, PNG, GIF).');
    $(this).val('');
  } else {
    $('#imageError').empty();
  }
});


$(document).on('change', '#docsPdfUpdateArticle', function() {
  var file = this.files[0];
  var fileType = file.type;
  var validFileTypes = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];

  if (!validFileTypes.includes(fileType)) {
    $('#docsPdfError').text('Solo se permiten archivos de Excel, PDF y Word.');
    $(this).val('');
  } else {
    $('#docsPdfError').empty();
  }
});

// validation of docs and images
$(document).ready(function () {
  $(document).on('change', '.image-upload', function() {
      var fileName = $(this).val();
      var extension = fileName.split('.').pop().toLowerCase();
      if (extension != 'jpg' && extension != 'jpeg' && extension != 'png' && extension != 'gif') {
          alert('Por favor, sube solo imágenes (jpg, jpeg, png o gif)');
          $(this).val('');
      }
  });

  $(document).on('change', '.document-upload', function() {
      var fileName = $(this).val();
      var extension = fileName.split('.').pop().toLowerCase();
      if (extension != 'pdf' && extension != 'doc' && extension != 'docx' && extension != 'xls' && extension != 'xlsx') {
          alert('Por favor, sube solo documentos PDF, Word o Excel');
          $(this).val('');
      }
  });
});


































});