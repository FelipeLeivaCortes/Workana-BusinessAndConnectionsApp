<?php
    use function Helpers\dd;
?>

<div class="container table-responsive">
    <h1 class="tracking-in-expand">Clientes registrados</h1>

    <table class="table DataTable table-hover slide-in-top table-stripe">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Empresa</th>
                <th scope="col">NIT</th>
                <th class="text-nowrap" scope="col">Contacto</th>
                <th class="text-nowrap" scope="col">Limite Crédito</th>
                <th class="text-nowrap" scope="col">Estado</th>
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
                // dd($users);
                foreach ($users as $q) {
                    $empresa            = $q['user'];
                    $statusClass        = $empresa['status_id'] == 1 ? 'text-success' : 'text-danger';
                    $limit              = $q['credit'][0]['credit_limit'] ?? null;
                    $contact_name       = $q['admin'][0]['u_name'] ?? null;
                    $contact_lastname   = $q['admin'][0]['u_lastname'] ?? null;
                    $contact            = is_null($contact_name) ? 'Sin Contacto' : $contact_name . ' ' . $contact_lastname;

                    echo '<tr>
                        <td>' . $empresa['c_id'] . '</td>
                        <td>' . $empresa['c_name'] . '</td>
                        <td>' . $empresa['c_num_nit'] . '</td>
                        <td>' . $contact . '</td>
                        <td>';
                            if (isset($limit)) {
                                echo number_format($limit, 2, ',', '.');
                            } else {
                                echo 'Aún no tiene asignado un límite crediticio';
                            }
                    echo '</td>
                    <td class="' . $statusClass . '">' . $empresa['status_name'] . '</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Clients", "Clients", "ModalDocumentsCompany", [], "ajax") . '" title="Visualizar Documentos" class="documentsCompany btn btn-outline-dark"><i class="fa-solid fa-eye"></i></button>
                                <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Company", "Company", "UpdateInfoCompanyClients", [], "ajax") . '" title="Editar Informacion empresa" class="updateInfoCompany btn btn-outline-warning"><i class="fa-solid fa-pencil"></i></button>
                                <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Clients", "Clients", "CreateMethodsPayCompanies", [], "ajax") . '" title="Asignar métodos de pago" class="createMethodsPay btn btn-outline-success"><i class="fa-solid fa-money-bill"></i></button>
                                <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Clients", "Clients", "updateCreditLimitModal", [], "ajax") . '" title="Editar límite" class="updateCreditLimit btn btn-outline-danger"><i class="fa-solid fa-credit-card"></i></button>
                                <button data-id="' . $empresa['c_id'] . '" data-url="'.Helpers\generateUrl("Clients","Clients","updateStatusCompanyAndUser",[],"ajax").'" title="Actualizar estado" class="updateStatusClient btn btn-outline-info"><i class="fa-solid fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>';
                }
			?>
        </tbody>
    </table>
</div>