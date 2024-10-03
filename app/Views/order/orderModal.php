
<style>
    .table-cell {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .quantityinput {
        flex-grow: 1;
        margin-right: 10px; /* Espacio entre el input y el botón */
        min-width: 80px; /* Ancho mínimo para el input */
    }
</style>

<div class="container table-responsive">
    <table id="tableModalCreateOrder" class="table DataTableModal table-sm slide-in-top table-hover table-striped text-center mx-auto">
        <thead>
            <tr>
                <th class="text-nowrap">Imagen</th>
                <th class="text-nowrap">Nombre</th>
                <th class=" padding-left-right">Descripción</th>
                <th class=" text-nowrap">Unidad de medida</th>
                <th class=" text-nowrap">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($articles as $art) { ?>
                    <tr>
                        <td>
                            <img class='viewArticle' value="<?= $art['ar_id']?>" src="<?= $art['ar_img_url']?>" alt="..."
                                height="100"
                                data-url="<?= Helpers\generateUrl("Stock", "Stock", "viewArticleDesc", [], "ajax") ?>"
                                data-value="<?= $art['ar_id'] ?>">
                        </td>
                        <td><?= $art['ar_name']?></td>
                        <td class="truncate"><?= $art['ar_desc']?></td>
                        <td><?= $art['ar_measurement_value']?> KG</td>
                        <td class="table-cell" style="height: 100px;">
                            <input min="1" type="number" class="mt-2 mb-2 quantityinput form form-control" name="quantity" id="">
                            <button data-url="<?= Helpers\generateUrl("Order","Order","AddArticlesAjax",[],"ajax");?>"
                                value="<?= $art['ar_id']?>" id="addArticleOrder" class="btn btn-outline-primary">
                                +
                            </button>
                        </td>
                    </tr>
            <?php } ?>

        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.container > .DataTable').DataTable().destroy();
        $('.container > .DataTable').DataTable({
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
            }
        });
    });
</script>
