<div class="container p-4 slide-in-top">
    <h2>Cambio de contraseña</h2>
    <form method="post" action="<?= Helpers\generateUrl("Company","Company","UpdatePasswordUser",[],"ajax")?>">
        <div class="form-group">
            <label for="new-password">Nueva contraseña:</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new-password" name="new-password" required>
                <button class="btn btn-outline-secondary" type="button" id="toggle-password"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirmar nueva contraseña:</label>
            <div class="input-group">
                <input type="hidden" name="u_id" value="<?= $u_id?>">
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                <button class="btn btn-outline-secondary" type="button" id="toggle-confirm-password"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>
        <div class="col-md-6 p-2">
            <button type="submit" id="updatePasswordButton" class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>