<div class="container table-responsive">
    <h1 class="tracking-in-expand">Pedidos</h1>
    <div class="d-flex justify-content-between mb-3">
        <span class="lead tracking-in-expand">Total de pedidos: <b><?= count($orders);?></b></span>
    </div>
    <div class="table-responsive">

        <table class="table DataTable table-hover slide-in-top table-stripe">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Fecha del documento</th>
                    <th scope="col">Estado del documento</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Acciones</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($orders as $q) {
                        echo '<tr>
                        <td>'.$q['order_id'].'</td>
                        <td>'.$q['c_name'].'</td>
                        <td>'.$q['origin'].'</td>
                        <td>'.$q['order_name'].'</td>
                        <td>'.$q['order_date'].'</td>
                        <td>'.$q['state_name_es'].'</td>
                        <td>$'.number_format($q['order_total'], 0, ',', '.')
                        .'</td>
                        <td class="text-center">
                        <div class="btn-group">';

                        if (isset($q['order_url_document'])) {
                            echo '<button data-url="'.$q['order_url_document'].'" title="Visualizar pedido" class="pdfModalLink btn btn-outline-warning"><i class="fa-solid fa-eye"></i></button>
                            <button data-company="'.$q['c_id'].'"data-id="'.$q['order_id'].'"  data-url="'.Helpers\generateUrl("Order","Order","modalStatusOrder",[],"ajax").'" title="Aceptar documento" class="ModalAcceptDocumentOrder btn btn-outline-primary"><i class="fa-solid fa-circle-check"></i></button>
                            <a href="'.Helpers\generateUrl("Order", "Order", "viewDetaillsOrder", ['order_id' => $q['order_id']]) .'" title="Visualizar detalles de la orden" class="btn btn-outline-info"><i class="bx bx-file"></i></a>';
                        } else {
                            echo '<button data-company="'.$q['c_id'].'"data-id="'.$q['order_id'].'"  data-url="'.Helpers\generateUrl("Order","Order","modalStatusOrder",[],"ajax").'" title="Aceptar documento" class="ModalAcceptDocumentOrder btn btn-outline-primary"><i class="fa-solid fa-circle-check"></i></button>';
                        }

                        echo '</div>
                            </td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>