$(document).ready(function () {
    $(document).on("click","#createGroup",function () {
        let url = $(this).attr('data-url');
        $.ajax({
            type: "POST",
            url: url,
            success: function (response) {
                $("#ModalContent").html(response);
                $("#ModalLarge").modal("show"); 
                groups();
               

            }
        });
    })

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
            groups();
          }
        });
});

    function groups() {
                     // Obtener los elementos de los campos de precio y porcentaje de descuento
                     const priceInput = $('#price');
                     const discountPercentageInput = $('#discount_percentage');
     
                     // Agregar eventos para habilitar o deshabilitar los campos según sea necesario
                     priceInput.on('input', function() {
                         if (priceInput.val().trim() !== '') {
                             discountPercentageInput.prop('disabled', true);
                             discountPercentageInput.val('');
                         } else {
                             discountPercentageInput.prop('disabled', false);
                         }
                     });
     
                     discountPercentageInput.on('input', function() {
                         if (discountPercentageInput.val().trim() !== '') {
                             priceInput.prop('disabled', true);
                             priceInput.val('');
                         } else {
                             priceInput.prop('disabled', false);
                         }
                     });
     
                     // CATEGORY
                     const categoryOptions = $('.category-option');
                     const categoryDropdown = $('.category-dropdown');
     
                     // Mostrar el listado al hacer clic en el campo de búsqueda o obtener el foco
                     $('#categorySearch').on('click focus', function() {
                         categoryDropdown.show();
                     });
     
                     // Ocultar el listado cuando se pierde el foco del campo de búsqueda
                     $('#categorySearch').on('blur', function() {
                         setTimeout(function() {
                             categoryDropdown.hide();
                         }, 200); // Pequeño retraso para permitir hacer clic en el listado
                     });
     
                     $('#categorySearch').on('input', function() {
                         const searchValue = $(this).val().trim().toLowerCase();
     
                         // Mostrar/ocultar las opciones de categoría basadas en el valor de búsqueda
                         categoryOptions.each(function() {
                             const categoryText = $(this).text().toLowerCase();
                             if (categoryText.includes(searchValue)) {
                                 $(this).show();
                             } else {
                                 $(this).hide();
                             }
                         });
                     });
                     // Manejar clic en una opción de categoría
                     $(document).on('click', '.category-option', function() {
                         const categoryId = $(this).attr('data-value');
                         const categoryName = $(this).text();
     
                         // Evitar agregar la misma categoría más de una vez
                         if (!$(`.selected-category[data-value="${categoryId}"]`).length) {
                             // Mostrar categoría seleccionada como "tag"
                             const selectedCategory = $(
                                 '<div class="col-md-3 mt-2"><span class="selected-category badge bg-primary" data-value="' +
                                 categoryId +
                                 '">' + categoryName +
                                 '<i class="fa-solid fa-circle-xmark remove-category"></i></span>\
                                 <input type="hidden" value="'+categoryId+'" name="categories[]" ></div>');
                             $('#selectedCategories').append(selectedCategory);
     
                             // Limpiar el campo de búsqueda
                             $('#categorySearch').val('');
     
                             // Cerrar el menú desplegable
                             categoryDropdown.hide();
                         }
                     });
                         // Manejar clic en el botón "x" para eliminar una categoría seleccionada
                         $(document).on('click', '.remove-category', function() {
                         $(this).parent().remove();
                         if ($('.selected-category').length === 0) {
                             categoryDropdown.hide();
                         }
                     });
     
                     // SUBCATEGORY
                     const subcategoryOptions = $('.subcategory-option');
                     const subcategoryDropdown = $('.subcategory-dropdown');
     
                     // Mostrar el listado al hacer clic en el campo de búsqueda o obtener el foco
                     $('#subcategorySearch').on('click focus', function() {
                         subcategoryDropdown.show();
                     });
     
                     // Ocultar el listado cuando se pierde el foco del campo de búsqueda
                     $('#subcategorySearch').on('blur', function() {
                         setTimeout(function() {
                             subcategoryDropdown.hide();
                         }, 200); // Pequeño retraso para permitir hacer clic en el listado
                     });
     
                     $('#subcategorySearch').on('input', function() {
                         const searchValue = $(this).val().trim().toLowerCase();
     
                         // Mostrar/ocultar las opciones de categoría basadas en el valor de búsqueda
                         subcategoryOptions.each(function() {
                             const categoryText = $(this).text().toLowerCase();
                             if (categoryText.includes(searchValue)) {
                                 $(this).show();
                             } else {
                                 $(this).hide();
                             }
                         });
                     });
                     // Manejar clic en una opción de categoría
                     $(document).on('click', '.subcategory-option', function() {
                         const subcategoryId = $(this).attr('data-value');
                         const subcategoryName = $(this).text();
     
                         // Evitar agregar la misma categoría más de una vez
                         if (!$(`.selected-subcategory[data-value="${subcategoryId}"]`).length) {
                             // Mostrar categoría seleccionada como "tag"
                             const selectedsubCategory = $(
                                 '<div class="col-md-3 mt-2"><span class="selected-subcategory badge bg-primary" data-value="' +
                                 subcategoryId +
                                 '">' + subcategoryName +
                                 '<i class="fa-solid fa-circle-xmark remove-subcategory"></i></span>\
                                 <input type="hidden" value="'+subcategoryId+'" name="subcategories[]" ></div>');
                             $('#selectedSubcategories').append(selectedsubCategory);
     
                             // Limpiar el campo de búsqueda
                             $('#subcategorySearch').val('');
     
                             // Cerrar el menú desplegable
                             subcategoryDropdown.hide();
                         }
                     });
                         // Manejar clic en el botón "x" para eliminar una categoría seleccionada
                         $(document).on('click', '.remove-subcategory', function() {
                         $(this).parent().remove();
                         if ($('.selected-subcategory').length === 0) {
                             subcategoryDropdown.hide();
                         }
                     });
                     // COMPANIES
                     const companyOptions = $('.company-option');
                     const companyDropdown = $('.company-dropdown');
     
                     // Mostrar el listado al hacer clic en el campo de búsqueda o obtener el foco
                     $('#companySearch').on('click focus', function() {
                         companyDropdown.show();
                     });
     
                     // Ocultar el listado cuando se pierde el foco del campo de búsqueda
                     $('#companySearch').on('blur', function() {
                         setTimeout(function() {
                             companyDropdown.hide();
                         }, 200); // Pequeño retraso para permitir hacer clic en el listado
                     });
     
                     $('#companySearch').on('input', function() {
                         const searchValue = $(this).val().trim().toLowerCase();
     
                         // Mostrar/ocultar las opciones de categoría basadas en el valor de búsqueda
                         companyOptions.each(function() {
                             const categoryText = $(this).text().toLowerCase();
                             if (categoryText.includes(searchValue)) {
                                 $(this).show();
                             } else {
                                 $(this).hide();
                             }
                         });
                     });
                     // Manejar clic en una opción de categoría
                     $(document).on('click', '.company-option', function() {
                         const companyId = $(this).attr('data-value');
                         const companyName = $(this).text();
     
                         // Evitar agregar la misma categoría más de una vez
                         if (!$(`.selected-company[data-value="${companyId}"]`).length) {
                             // Mostrar categoría seleccionada como "tag"
                             const selectedcompany = $(
                                 '<div class="col-md-3 mt-2"><span class="selected-company badge bg-primary" data-value="' +
                                 companyId +
                                 '">' + companyName +
                                 '<i class="fa-solid fa-circle-xmark remove-company"></i></span>\
                                 <input type="hidden" value="'+companyId+'" name="companies[]" ></div>');
                             $('#selectedCompanies').append(selectedcompany);
     
                             // Limpiar el campo de búsqueda
                             $('#companySearch').val('');
     
                             // Cerrar el menú desplegable
                             companyDropdown.hide();
                         }
                     });
                         // Manejar clic en el botón "x" para eliminar una categoría seleccionada
                         $(document).on('click', '.remove-company', function() {
                         $(this).parent().parent().remove();
                         if ($('.selected-company').length === 0) {
                             companyDropdown.hide();
                         }
                     });
                     // ARTICLES 
                     const articleOptions = $('.article-option');
                     const articleDropdown = $('.article-dropdown');
     
                     // Mostrar el listado al hacer clic en el campo de búsqueda o obtener el foco
                     $('#articleSearch').on('click focus', function() {
                         articleDropdown.show();
                     });
     
                     // Ocultar el listado cuando se pierde el foco del campo de búsqueda
                     $('#articleSearch').on('blur', function() {
                         setTimeout(function() {
                             articleDropdown.hide();
                         }, 200); // Pequeño retraso para permitir hacer clic en el listado
                     });
     
                     $('#articleSearch').on('input', function() {
                         const searchValue = $(this).val().trim().toLowerCase();
     
                         // Mostrar/ocultar las opciones de categoría basadas en el valor de búsqueda
                         articleOptions.each(function() {
                             const categoryText = $(this).text().toLowerCase();
                             if (categoryText.includes(searchValue)) {
                                 $(this).show();
                             } else {
                                 $(this).hide();
                             }
                         });
                     });
                     // Manejar clic en una opción de categoría
                     $(document).on('click', '.article-option', function() {
                         const articleId = $(this).attr('data-value');
                         const articleName = $(this).text();
     
                         // Evitar agregar la misma categoría más de una vez
                         if (!$(`.selected-article[data-value="${articleId}"]`).length) {
                             // Mostrar categoría seleccionada como "tag"
                             const selectedarticle = $(
                                 '<div class="col-md-3 mt-2"><span class="selected-article badge bg-primary" data-value="' +
                                 articleId +
                                 '">' + articleName +
                                 '<i class="fa-solid fa-circle-xmark remove-article"></i></span>\
                                 <input type="hidden" value="'+articleId+'" name="articles[]" ></div>');
                             $('#selectedArticle').append(selectedarticle);
     
                             // Limpiar el campo de búsqueda
                             $('#articleSearch').val('');
     
                             // Cerrar el menú desplegable
                             articleDropdown.hide();
                         }
                     });
                         // Manejar clic en el botón "x" para eliminar una categoría seleccionada
                         $(document).on('click', '.remove-article', function() {
                         $(this).parent().remove();
                         if ($('.selected-article').length === 0) {
                             companyDropdown.hide();
                         }
                     });
     
    }


    // columns modal add values

    // $(document).on("click", "#addFieldsColumn1", function() {
    //     var selectedValue = $("select[name='company']").val();
    //     var selectedOptionText = $("select[name='company'] option:selected").text();
        
    //     if (selectedValue !== "" && !$("#listColumn1 li[data-value='" + selectedValue + "']").length) {
    //         var newListItem = '<li data-value="' + selectedValue + '">' + '<input type="hidden" value="'+selectedValue+'" name="companies[]">'+
    //             '<div class="d-flex align-items-center">' +
    //             '<span class="mr-auto">' + selectedOptionText + '</span>' +
    //             '<button class="btn btn-danger remove-item"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
    //             '</div>' +
    //             '</li>';
    //         $("#listColumn1").append(newListItem);
    //     }
    // });

    // $(document).on("click", "#addFieldsColumn2", function() {
    //     var selectedValue = $("select[name='category']").val();
    //     var selectedOptionText = $("select[name='category'] option:selected").text();
        
    //     if (selectedValue !== "" && !$("#listColumn2 li[data-value='" + selectedValue + "']").length) {
    //         var newListItem = '<li data-value="' + selectedValue + '">' + '<input type="hidden" value="'+selectedValue+'" name="categories[]">'+
    //             '<div class="d-flex align-items-center">' +
    //             '<span class="mr-auto">' + selectedOptionText + '</span>' +
    //             '<button class="btn btn-danger remove-item"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
    //             '</div>' +
    //             '</li>';
    //         $("#listColumn2").append(newListItem);
    //     }
    // });
    // $(document).on("click", "#addFieldsColumn3", function() {
    //     var selectedValue = $("select[name='subcategory']").val();
    //     var selectedOptionText = $("select[name='subcategory'] option:selected").text();
        
    //     if (selectedValue !== "" && !$("#listColumn3 li[data-value='" + selectedValue + "']").length) {
    //         var newListItem = '<li data-value="' + selectedValue + '">' + '<input type="hidden" value="'+selectedValue+'" name="subcategories[]">'+
    //             '<div class="d-flex align-items-center">' +
    //             '<span class="mr-auto">' + selectedOptionText + '</span>' +
    //             '<button class="btn btn-danger remove-item"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
    //             '</div>' +
    //             '</li>';
    //         $("#listColumn3").append(newListItem);
    //     }
    // });
    // $(document).on("click", "#addFieldsColumn4", function() {
    //     var selectedValue = $("select[name='article']").val();
    //     var selectedOptionText = $("select[name='article'] option:selected").text();
        
    //     if (selectedValue !== "" && !$("#listColumn4 li[data-value='" + selectedValue + "']").length) {
    //         var newListItem = '<li data-value="' + selectedValue + '">' + '<input type="hidden" value="'+selectedValue+'" name="articles[]">'+
    //             '<div class="d-flex align-items-center">' +
    //             '<span class="mr-auto">' + selectedOptionText + '</span>' +
    //             '<button class="btn btn-danger remove-item"><i class="fa-sharp fa-solid fa-trash"></i></button>' +
    //             '</div>' +
    //             '</li>';
    //         $("#listColumn4").append(newListItem);
    //     }
    // });
    // $(document).on("click", ".remove-item", function() {
    //     $(this).closest('li').remove();
    // });
    
  
    



});