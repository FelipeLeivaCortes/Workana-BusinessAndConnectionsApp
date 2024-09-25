<div class="container">
    <h1 class="text-center">REGISTRO DE CLIENTE PORTAL USUARIOS</h1>
    <form id="registerUser"
        action='<?php echo Helpers\generateUrl("Company","Company","CompanyRequestRegister",[],"ajax");?>' method="post"
        enctype="multipart/form-data">
        <div class="row">
            <div class="container p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input name="email" id="email" type="text" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h1>Agregar Suscripción al Plan</h1>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="plan">Duración del plan</label>
                            <select id="plan" name="plan" class="form-select" onchange="updateDates(this.value)"
                                required>
                                <option value="" disabled selected>Seleccione un plan</option>
                                <option value="3">3 meses</option>
                                <option value="6">6 meses</option>
                                <option value="12">12 meses</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" id="fecha_inicio" name="date_init" class="form-control" required
                                min="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" id="fecha_fin" name="date_end" class="form-control" required
                                min="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 p-4">
                    <button class="btn btn-primary btn-block" type="submit">Registrar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
<div class="container table-responsive">
    <h1 class="tracking-in-expand">Portal Usuarios.</h1>
    <div class="d-flex justify-content-between mb-3">
        <span class="lead tracking-in-expand">Total de clientes: <b><?= count($users);?></b></span>
    </div>
    <table class="DataTable text-center table align-middle slide-in-top table-hover table-responsive ">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha inicio suscripción</th>
                <th scope="col">Fecha fin suscripción</th>
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
            foreach ($users as $q) {
                $empresa        = $q['company'][0];
                $subscription   = $q['subscription'][0];
                $statusColor    = ($subscription['status_name'] === 'Activo') ? 'green' : 'red';

                echo '<tr>
                    <td>' . $empresa['c_id'] . '</td>
                    <td>' . $empresa['c_name'] . '</td>
                    <td style="color: ' . $statusColor . '">' . $subscription['status_name'] . '</td>
                    <td>' . $subscription['subs_date_init'] . '</td>
                    <td>' . $subscription['subs_date_end'] . '</td>
                    <td class="text-center">';

                echo '<div class="btn-grid">
                    <div class="btn-group">
                        <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Clients","Clients","ModalDocumentsCompany",[],"ajax") . '" title="Visualizar Documentos" class="documentsCompany btn btn-outline-dark"><i class="fa-solid fa-eye"></i></button>
                        <button data-id="' . $empresa['c_id'] . '" data-url="' . Helpers\generateUrl("Company","Company","UpdateInfoCompany",[],"ajax") . '" title="Editar Informacion empresa" class="updateInfoCompany btn btn-outline-warning"><i class="fa-solid fa-pencil"></i></button>
                        <button data-id="' . $empresa['c_id'] . '" data-user="' . $q['u_id'] . '" data-url="' . Helpers\generateUrl("Clients","Clients","UpdateStatusCompanyActive",[],"ajax") . '" title="Activar/Desactivar cuenta" class="updateStatusCompany btn btn-outline-secondary"><i class="fa-solid fa-sliders"></i></button>
                        <button data-id="' . $empresa['c_id'] . '" data-user="' . $q['u_id'] . '" data-url="' . Helpers\generateUrl("Clients","Clients","UpdatePlansCompany",[],"ajax") . '" title="Actualizar vigencia del plan" class="SubscriptionPlans btn btn-outline-success"><i class="fa-solid fa-money-bill"></i></button>
                    </div>
                </div>';

                echo '</td>
                </tr>';
            }
			?>
        </tbody>
    </table>
</div>