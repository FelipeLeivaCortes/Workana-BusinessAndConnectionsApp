<div class="container p-4">
    <h1>Cambiar Estado de Empresa</h1>

    <form action="<?= Helpers\generateUrl("Company","Company","updateStatusClientPortal")?>" method="POST" action="cambiar_estado_empresa.php">
        <?php foreach ($company as $c) {?>
        <label for="empresa_id">Nombre de la Empresa:</label>
        <label class="form form-control"><?= $c['c_name']?></label>

        <label for="estado">Estado:</label>
        <select id="estado" name="status_id" class="form-select" required>
            <option value="" disabled>Seleccione una opción</option>
            <option value="1" <?php if ($c['status_id'] == 1) { echo 'selected'; } ?>>Activo</option>
            <option value="2" <?php if ($c['status_id'] == 2) { echo 'selected'; } ?>>Inactivo</option>
        </select>
        <div class="container p-4">
            <input type="hidden"  name="c_id" value="<?=$c_id?>">
            <input type="hidden"  name="u_id" value="<?=$u_id?>">
            <input class="btn btn-outline-primary"type="submit" value="Actualizar">
        </div>
        <?php } ?>
    </form>
</div>
