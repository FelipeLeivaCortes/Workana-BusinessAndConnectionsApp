<div class="p-4">
    <h1>Confirmar Pedido</h1>

    <form action="<?=Helpers\generateUrl("Order","Order","updateStatesOrder")?>" method="post">
        <label for="estado">Cambiar el estado del Pedido:</label>
        <select class="form-select" name="state_order" id="state_order">
            <option value="" selected disabled>Seleccione una opcion</option>

            <?php foreach ($states as $state) {
              if (strcasecmp($state['state_name_en'], 'Approved') == 0 || strcasecmp($state['state_name_en'], 'Cancelled') == 0) {
                echo '<option value="' . $state['order_state_id'] . '">' . $state['state_name_es'] . '</option>';
              }
            } ?>
        </select>
        <div class="col-md-6 mt-2">

            <input type="hidden" name="order_id" value="<?=$order[0]['order_id']?>">
            <input type="hidden" name="c_id" value="<?=$c_id?>">
            <button type="submit" class="btn btn-outline-success">Actualizar
                Estado</button>
        </div>
    </form>
</div>
