<?php foreach ($company as $c) { ?>
<div class="container">
    <h1>Actualizar Límite Crediticio</h1>
    <form action="<?= Helpers\generateUrl("Clients","Clients","UpdateLimitCredit") ?>" method="POST">
        <div class="form-group p-2">
            <label for="empresa">Empresa:</label>
            <input type="text" class="form-control" value="<?= $c['c_name'] ?>" readonly>
            <input type="hidden" name="c_id" value="<?= $c['c_id'] ?>">
        </div>

        <div class="form-group p-2">
            <label for="limite-crediticio">Límite Crediticio:</label>
            <input type="text" class="form-control" id="credit_limit_input" name="credit_limit_new"
                value="<?= !empty($c['LimitCredit']) ? number_format($c['LimitCredit'][0]['credit_limit'], 0, '.', ',') : '' ?>">
        </div>


        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
<?php } ?>