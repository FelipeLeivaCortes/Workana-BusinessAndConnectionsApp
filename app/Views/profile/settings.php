<div class="container">
  <div class="row justify-content-center">
    <h4 class="text-center">Contraseña</h4>
    <div class="col-md-8">
      <form action="<?=Helpers\generateUrl("User","User","ChangePassword")?>" method="post"   id="passwordForm">
        <hr>
        <h4>Cambiar contraseña</h4>
        <div class="form-group">
          <label for="contraseña_actual">Contraseña actual:</label>
          <input type="password" class="form-control" name="contraseña_actual" id="contraseña_actual">
          <small id="contraseña_actual_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="nueva_contraseña">Nueva contraseña:</label>
          <input type="password" class="form-control" name="nueva_contraseña" id="nueva_contraseña">
          <small id="nueva_contraseña_error" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="confirmar_contraseña">Confirmar nueva contraseña:</label>
          <input type="password" class="form-control" name="confirmar_contraseña" id="confirmar_contraseña">
          <small id="confirmar_contraseña_error" class="form-text text-danger"></small>
          <small id="nueva_contraseña_error" class="form-text text-danger"></small>

        </div>
        <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
      </form>
    </div>
  </div>
</div>
