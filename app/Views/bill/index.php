<section>
    <div class="container">
        <h1 class="tracking-in-expand">Facturas Pendientes <i class="fa-solid fa-pen-to-square"></i></h1>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table DataTable table-sm slide-in-top table-hover table-striped">
                        <thead>
                            <tr>
                                <th>N° Documento</th>
                                <th>Fecha Documento</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <!-- <th>Acciones</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($bills as $bill) {
                                echo '<tr>
                                    <td>'.$bill->NumeroDocumento.'</td>
                                    <td>'.$bill->FechaDocumento.'</td>
                                    <td>'.$bill->Empresa.'</td>
                                    <td>$'.$bill->TotalDocumento.'</td>';
                                
                                // echo '<td class="text-center">
                                //         <div class="btn-group">
                                //             <button data-url="#" title="Visualizar Factura" class="pdfModalLink btn btn-outline-warning">
                                //                 <i class="fa-solid fa-eye"></i>
                                //             </button>

                                //             <a href="'.Helpers\generateUrl("Bill", "Bill", "viewDetaillBill", ['id' => $bill->NumeroDocumento]) .'"
                                //                 title="Visualizar detalles Factura" class="btn btn-outline-info">
                                //                 <i class="bx bx-file"></i>
                                //             </a>
                                //         </div>
                                //     </td>
                                // </tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
