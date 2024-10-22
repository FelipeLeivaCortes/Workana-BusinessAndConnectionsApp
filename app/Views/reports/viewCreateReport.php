<div class="row p-4">
    <div class="<?php echo ($_SESSION['RolUser'] == '2') ? 'col-md-4' : 'col-md-6'; ?>">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Reporte Cotizaciones</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo Helpers\generateUrl("Reports","Reports","reportsQuotes",[],"ajax")?>" method="POST">
                    <label for="cotizacion-fecha-inicio">Fecha de inicio:</label>
                    <input class="form form-control" type="date" id="cotizacion-fecha-inicio"
                        name="cotizacion-fecha-inicio">

                    <label for="cotizacion-fecha-fin">Fecha de fin:</label>
                    <input class="form form-control" type="date" id="cotizacion-fecha-fin" name="cotizacion-fecha-fin">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="DateTodayQuote">
                        <label class="form-check-label" for="exampleCheckbox">
                            Hasta el día de hoy?
                        </label>
                    </div>
                    <button class="btn btn-outline-primary"  type="submit">Generar reporte</button>
                </form>
            </div>
        </div>
    </div>

    <div class="<?php echo ($_SESSION['RolUser'] == '2') ? 'col-md-4' : 'col-md-6'; ?>">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Reporte Pedidos</h5>
            </div>
            <div class="card-body">
                <form  action="<?= Helpers\generateUrl("Reports","Reports","reportsOrders",[],"ajax")?>" method="POST">
                    <label for="pedidos-fecha-inicio">Fecha de inicio:</label>
                    <input class="form form-control" type="date" id="pedidos-fecha-inicio" name="order-date-init">

                    <label for="pedidos-fecha-fin">Fecha de fin:</label>
                    <input class="form form-control" type="date" id="pedidos-fecha-fin" name="order-date-end">

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="DateTodayOrder">
                        <label class="form-check-label" for="exampleCheckbox">
                            Hasta el día de hoy?
                        </label>
                    </div>
                    <button class="btn btn-outline-primary" type="submit">Generar reporte</button>
                </form>
            </div>
        </div>
    </div>
    <!-- <?php if ($_SESSION['RolUser']=='2') {?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Reporte de Stock</h5>
            </div>
            <div class="card-body">
                <form  action="<?= Helpers\generateUrl("Reports","Reports","reportsStockByAjax",[],"ajax")?>" method="POST">
                    <label for="stock-fecha-inicio">Fecha de inicio:</label>
                    <input class="form form-control" type="date" id="stock-fecha-inicio" name="stock-fecha-inicio">

                    <label for="stock-fecha-fin">Fecha de fin:</label>
                    <input class="form form-control" type="date" id="stock-fecha-fin" name="stock-fecha-fin">

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="exampleCheckbox">
                        <label class="form-check-label" for="exampleCheckbox">
                            Hasta el día de hoy?
                        </label>
                    </div>
                    <button class="btn btn-outline-primary" type="submit">Generar reporte</button>
                    <a href="uploads/reports/Reporte_Inventario.xlsx" class="btn btn-outline-success"  type="submit">Descargar reporte</a>
                </form>
            </div>
        </div>
    </div>
    <?php }?> -->

</div>
