<div class="container">
        <h1>Actualizar Estado de Usuario</h1>
        <form action="<?= Helpers\generateUrl("Company","Company","updateStatusUserOfCompany",[],"ajax")?>" method="POST">
  <div class="mb-3">
    <label for="usuario">Usuario:</label>
    <input type="text" id="u_name" name="u_name" value="<?=$user['u_name'].' '.$user['u_lastname'];?>" class="form-control" readonly value="Nombre de Usuario">
  </div>
  <div class="mb-3">
    <label for="estado">Estado:</label>
    <select id="estado" name="estado" class="form-select">
      <?php foreach (["1" => "Activo", "2" => "Inactivo"] as $value => $label): ?>
        <?php $selected = ($user['status_id'] == $value) ? 'selected' : ''; ?>
        <option value="<?= $value ?>" <?= $selected ?>><?= $label ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <input type="hidden" name="u_id" id="u_id" value="<?= $user['u_id'] ?>">
  <input type="hidden" name="u_email" id="u_email" value="<?= $user['u_email'] ?>">
  <button type="button" id="updateStatusUser" class="btn btn-primary">Actualizar</button>
</form>

    </div>