<div class="container table-responsive">
    <h1 class="tracking-in-expand">Vendedores</h1>
    <div class="d-flex justify-content-between mb-3">
        <span class="lead tracking-in-expand">Total de vendedores: <b><?= count($sellers);?></b></span>
        <button id="createSeller" class="btn btn-outline-primary"
            data-url="<?= Helpers\generateUrl("Clients","Clients","CreateSeller",[],"ajax")?>">Crear vendedores</button>        
    </div>
    <div class="d-flex float-end mb-3">
        <button id="CreateAsignButgetSeller" class="btn btn-outline-primary"
            data-url="<?= Helpers\generateUrl("Clients","Clients","CreateAsignButgetSeller",[],"ajax")?>">Asignar Presupuesto</button>        
    </div>

    <table class="table DataTable table-hover slide-in-top table-stripe text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Numero de telefono</th>
                <th scope="col">Codigo</th>
                <th scope="col">Acciones</th>
            </tr>
            <tr>
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
				foreach ($sellers as $s) {
					echo '<tr>
					<td>'.$s['s_id'].'</td>
					<td>'.$s['s_name'].'</td>
					<td>'.$s['s_email'].'</td>
					<td>'.$s['s_phone'].'</td>
					<td>'.$s['s_code'].'</td>
					<td class="text-center">
                    <div class="btn-group">
					<button title="Asignar cliente" class="btn btn-outline-dark" data-id='.$s['s_id'].' id="CompanyAndSeller" data-url='.Helpers\generateUrl("Clients","Clients","SellerAndCompanyModal",[],"ajax").'><i class="fa-solid fa-building"></i></button>
					<button title="Actualizar Vendedor" class="btn btn-outline-warning" data-id='.$s['s_id'].' id="UpdateSeller" data-url='.Helpers\generateUrl("Clients","Clients","SellerUpdateModal",[],"ajax").'><i class="fa-solid fa-pencil"></i></button>
                    <button title="Presupuesto Ventas" class="btn btn-outline-primary" data-id='.$s['s_id'].' id="SalesBudget" data-url='.Helpers\generateUrl("Clients","Clients","SalesBudgetModal",[],"ajax").'><i class="fa-solid fa-credit-card"></i></button>
                    </div>
					</td>
					</tr>';
				}
			?>
        </tbody>
    </table>
</div>