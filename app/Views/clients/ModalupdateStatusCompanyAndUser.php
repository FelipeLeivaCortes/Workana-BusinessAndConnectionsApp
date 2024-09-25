<div class="container mt-4">
    <h1>Actualizar Estado de Empresa</h1>
    <form action="<?= Helpers\generateUrl("Clients","Clients","UpdateStatusOfClient") ?>" method="post">
        <div class="form-group">
            <label for="estado_empresa">Estado de la Empresa:</label>
            <select id="status_company" name="status_company" class="form-select">
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </select>
            <input type="hidden" name="c_id" value="<?=$c_id?>">
        </div>
        <button type="submit" class="btn btn-primary mt-3 mb-3">Actualizar Estado</button>
    </form>
</div>