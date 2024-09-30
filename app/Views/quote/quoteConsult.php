<div class="container">
    <h1 class="tracking-in-expand">Mis cotizaciones</h1>
    <div class="d-flex justify-content-between mb-3">
        <span class="lead tracking-in-expand">Total de cotizaciones: <b><?= count($quotes);?></b></span>
        <a class="btn btn-primary" href="<?= Helpers\generateUrl("Quote","Quote","ViewCreateQuote");?>">Nueva
            cotizacion</a>
    </div>
    <table class="table DataTable table-hover slide-in-top table-stripe">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cotizante</th>
                <th scope="col">Valor</th>
                <th scope="col">Fecha del documento</th>
                <th scope="col">Fecha valida la cotizacion</th>
                <th scope="col">Estado del documento</th>
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
            </tr>
        </thead>
        <tbody>
            <?php
			foreach ($quotes as $q) {
                $originalDate = strtotime($q['quo_date']);
                $validDate = date('Y-m-d', strtotime('+3 days', $originalDate));
            
                echo '<tr>
                    <td>' . $q['quo_id'] . '</td>
                    <td>' . $q['quo_name'] . '</td>
                    <td>$' . number_format($q['quo_total'], 0, ',', '.'). '</td>
                    <td style="color:green;">' . date('Y-m-d', strtotime($q['quo_date'])) . '</td>
                    <td style="color:red;">' . $validDate . '</td>
                    <td>' . $q['quote_state_name'] . '</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button data-url="' . $q['quo_url_document'] . '" title="Visualizar pedido" class="pdfModalLink btn btn-outline-warning"><i class="fa-solid fa-eye"></i></button>';
            
                            if ($q['quote_state_id'] != 2) {
                                echo '<a href="' . Helpers\generateUrl('Order', 'Order', 'GenerateOrderSinceQuote', ['quo_id' => $q['quo_id']]) . '" title="Generar Pedido" class="GenerateOrderSinceQuote btn btn-outline-success">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>';
                            }
                        echo '</div></td>
                </tr>';
            }
            

			?>

        </tbody>
    </table>
</div>