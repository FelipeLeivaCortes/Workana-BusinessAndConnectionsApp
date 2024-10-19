<section>
    <div class="container">
        <h1 class="tracking-in-expand">Facturas <i class="fa-solid fa-pen-to-square"></i></h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table DataTable table-sm slide-in-top table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($bills as $bill) {
                                echo '<tr>
                                    <td>'.$bill['id'].'</td>
                                    <td>'.$bill['date'].'</td>
                                    <td>$'.$bill['amount'].'</td>
                                    <td>'.$bill['client'].'</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button data-url="'.$bill['url_doc'].'" title="Visualizar Factura" class="pdfModalLink btn btn-outline-warning">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <a href="'.Helpers\generateUrl("Bill", "Bill", "viewDetaillBill", ['id' => $bill['id']]) .'"
                                                title="Visualizar detalles Factura" class="btn btn-outline-info">
                                                <i class="bx bx-file"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
