<div class="col-md-12">
    <h3 class="tracking-in-expand">Perfil de usuarios</h3>
    <div class="row d-flex">
        <div class="col-md-6">
            <form id="insertUser" class="slide-in-top"
                action="<?= Helpers\generateUrl("Company","Company","insertUsersCompany",[],"ajax")?>" method="POST">
                <label for="">Nombre/s</label>
                <input name="u_name" type="text" class="form form-control">
                <label for="">Apellido/s</label>
                <input type="text" name="u_lastname" class="form form-control">
                <label for="">Telefono movil</label>
                <div class="input-group mb-3">
                    <input type="tel" name="u_phone" class="form-control">
                    <span class="input-group-text"><i class="fa-solid fa-phone" style="color: #000000;"></i></span>
                </div>
                <label for="">Correo electronico</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="u_email" aria-label="Correo electronico vigente"
                        aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>
                <label for="">Tipo de documento</label>
                <div class="input-group mb-3">
                    <select name="u_type_document" id="" class="form-select">
                        <option disabled="true" selected="true">Seleccione una opcion</option>
                        <option value="Cedula de ciudadania">Cedula de ciudadania</option>
                        <option value="Cedula de extranjeria">Cedula de extranjeria</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
                <label for="">Numero de documento</label>
                <div class="input-group mb-3">
                    <input type="number" name="u_document" class="form-control" aria-describedby="basic-addon2">
                </div>
                <div class="col-md-6">
                    <button type="button" id="RegisterUsersOfCompany" class="btn btn-outline-primary">Registrar
                        usuario</button>
                </div>
            </form>
        </div>

        <!-- LIST USERS -->
        <div class="col-12 table-responsive">
            <table id="usersTable"
                class="DataTable table  table-striped table-hover slide-in-top text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Empresa</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
                <tbody id="ListUsersOfCompany">
                    <?php foreach ($users as $u) {
                echo '<tr>
                        <td>'.$u['u_id'].'</td>
                        <td>'.$u['u_name'].'</td>
                        <td>'.$u['u_email'].'</td>
                        <td>'.$u['c_name'].'</td> 
                        <td>'.$u['rol_name'].'</td> 
                        <td>'.$u['status_name'].'</td> 
                        <td>
                            <div class="col-md-12 justify-content-start d-inline-flex">
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","ViewUserCompany",[],"ajax").'" class="btn btn-outline-info editUserProfile"><i class="fa-solid fa-pencil"></i></button>
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","viewchangePassword",[],"ajax").'" class="btn btn-outline-warning passwordUser"><i class="fa-solid fa-key"></i></button>
                                <button data-id="'.$u['u_id'].'" data-url="'.Helpers\generateUrl("Company","Company","disableUser",[],"ajax").'" class="btn btn-outline-danger disableUser"><i class="fa-solid fa-ban"></i></button>
                            </div>
                        </td>
                    </tr>';
            }?>
                </tbody>
            </table>
        </div>
    </div>

</div>