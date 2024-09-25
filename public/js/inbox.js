$(document).ready(function () {
$(document).on("click",".messageInboxRequest",function() {
    let url=$(this).attr("data-url");
    let id=$(this).attr("data-id");
        console.log(url);
        console.log(id);
        $.ajax({
            url: url,
            type: "POST",
            data:{id:id},
            success: function(datos) {     
                    $("#ModalContent").html(datos); 
                    $("#ModalLarge").modal("show");              
            }
        });
  })

  $(document).on("click", ".btnModalDocumentRequest", function() {
    let url = $(this).attr("data-url");
    let iframe = '<iframe src="' + url + '" frameborder="0" style="width: 100%; height:90vh;"></iframe>';
    $("#nestedModal .modal-body").html(iframe);
    $("#nestedModal").modal("show");
  });
  
  $(document).on("click", ".sendFormRequest", function() {
    // Obtener la opción seleccionada
    let opcion = $(this).data('opcion');
    console.log(opcion);
    // Establecer el valor del campo oculto con la opción seleccionada
    $(this).closest('.registerForm').find('.opcion').val(opcion);

    // Enviar el formulario
    $(this).closest('.registerForm').submit();
  });






})
