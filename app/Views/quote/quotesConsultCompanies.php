<div class="container table-responsive">
    <h1 class="tracking-in-expand">Cotizaciones</h1>

    <div class="d-flex justify-content-between mb-3">
        <span class="lead tracking-in-expand">Total de cotizaciones: <b><?= count($quotes);?></b></span>
        <button id="addQuouteValidity" class="btn btn-outline-primary"
            data-url="<?= Helpers\generateUrl("Quote","Quote","viewModalQuoteValidity",[],"ajax"); ?>"
            data-title="Agregar Fecha Vigencia de Cotización">Agregar Vigencia de Cotización   <i class="fa-solid fa-circle-plus"></i>
        </button>
    </div>

    <table class="table DataTable table-hover slide-in-top table-stripe">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Empresa</th>
                <th scope="col">Usuario</th>
                <th scope="col">Fecha del documento</th>
                <th scope="col">Fecha vigencia cotización</th>
                <th scope="col">Valor</th>
                <th scope="col">Acciones</th>
            </tr>
            <tr class="text-center">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="width:100px !important;"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
				foreach ($quotes as $q) {
                    $emptyDateQuoteValidity = '';
                    $classValidityQuote     = 'text-danger';

                    if (empty($q['c_dateQuoteValidity'])) {
                        $validityQuoteDate  = new DateTime($q['quo_date']);
                        $validityQuoteDate->modify('+3 days');
                        $emptyDateQuoteValidity = $validityQuoteDate->format('Y-m-d H:i:s');

                    } else {
                        $emptyDateQuoteValidity = $q['c_dateQuoteValidity'];

                    }

                    $validityDate   = new DateTime($emptyDateQuoteValidity);
                    $currentDate    = new DateTime();

                    if ($validityDate >= $currentDate) {
                        $classValidityQuote = 'text-success';
                    }

					echo '<tr>
					<td>'.$q['quo_id'].'</td>
					<td>'.$q['c_name'].'</td>
					<td>'.$q['quo_name'].'</td>
					<td>'.$q['quo_date'].'</td>
                    <td class="'.$classValidityQuote.'">'.$emptyDateQuoteValidity.'</td>
					<td>$'.number_format($q['quo_total'], 0, ',', '.').'</td>
					<td class="text-center">
                    <div class="btn-group">
					<button data-url="'.$q['quo_url_document'].'" title="Visualizar cotizacion" class="pdfModalLink btn btn-outline-warning"><i class="fa-solid fa-eye"></i></button>
					<a href="'.Helpers\generateUrl("Quote", "Quote", "viewDetaillsQuote", ['quo_id' => $q['quo_id']]) .'" title="Visualizar detalles cotización" class="btn btn-outline-info"><i class="bx bx-file"></i></a>
                    </div>
					</td>
					</tr>';
				}
			?>
        </tbody>
    </table>
</div>