<div class="modal-header">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="container p-4">    
    <h2>Asignar Presupuesto</h2>
    <form action="<?= Helpers\generateUrl("Clients", "Clients", "insertBudgetSeller") ?>" method="POST">
        <div class="form-group">
            <label for="estado">Nombre Vendedor:</label>
            <select class="form-select" name="id_seller" id="id_seller" required="">
                <option value="" selected disabled>Seleccione una opción</option>
                <?php foreach ($sellers as $seller) {
                    echo '<option value="' . $seller['s_id'] . '">' . $seller['s_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group mt-2">
            <label for="email">Presupuesto Objetivo Asignado(meta a alcanzar):</label>
            <input type="number" class="form-control" id="budgetGoal" name="budgetGoal" min="0" required>
        </div>
        <div class="form-group mt-2">
            <label for="startDate">Fecha Inicio:</label>
            <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
        </div>
        <div class="form-group mt-2">
            <label for="endDate">Fecha Fin:</label>
            <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
        </div>
        <div class="modal-footer mt-3">
            <button type="submit" class="btn btn-primary">Crear</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>