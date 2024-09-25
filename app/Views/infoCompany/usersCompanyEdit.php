<div class="container slide-in-top">
    <div class="row justify-content-center">
          <div class="card">
            <div class="card-header">Editar Usuario</div>
            <div class="card-body">
                <form action="<?=Helpers\generateUrl("Company","Company","updateInfoUser",[],"ajax")?>"method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre/s</label>
                        <input name="name" type="text" value="<?=$user['u_name']?>" class="form-control" id="nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido/s</label>
                        <input  name="lastname" type="text" value="<?=$user['u_lastname']?>" class="form-control" id="apellido">
                    </div>
                    <div class="form-group">
                        <label for="alias">Telefono movil</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-phone"
                                    style="color: #000000;"></i></span>
                            <input type="tel" value="<?=$user['u_phone']?>" name="phone" class="form-control">
                            <div class="input-group-prepend">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Correo electronico</label>
                        <div class="input-group mb-3">
                            <input type="text" value="<?=$user['u_email']?>" class="form-control" name="email"
                                aria-label="Correo electronico vigente" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">@example.com</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo de documento</label>
                        <div class="input-group mb-3">
                            <select name="type_document" id="" class="form-select">
                                <option disabled="true" selected="true">Seleccione una opcion</option>
                                <option value="Cedula de ciudadania"
                                    <?=($user['u_type_document'] == 'Cedula de ciudadania') ? 'selected' : ''?>>Cedula
                                    de ciudadania</option>
                                <option value="Cedula de extranjeria"
                                    <?=($user['u_type_document'] == 'Cedula de extranjeria') ? 'selected' : ''?>>Cedula
                                    de extranjeria</option>
                                <option value="Pasaporte"
                                    <?=($user['u_type_document'] == 'Pasaporte') ? 'selected' : ''?>>Pasaporte</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Numero de documento</label>
                        <div class="input-group mb-3">
                            <input type="number" name="num_document" value="<?=$user['u_document']?>" class="form-control"
                                aria-describedby="basic-addon2">
                        </div>
                    </div>
                    <div class="col-md-12 p-4 d-flex">
                        <div class="col-md-3">
                          <input type="hidden" name="id" value="<?=$user['u_id']?>">
                            <button type="submit" id="updateInfoUserForm" class="btn btn-outline-primary">Guardar cambios</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-danger"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>