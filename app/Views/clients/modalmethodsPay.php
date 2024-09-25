<div class="container">
    <h1>Seleccionar Métodos de Pago</h1>
    <form action="<?=Helpers\generateUrl("Clients","Clients","AddMethodsPayCompany")?>" method="POST">
        <?php foreach ($methods as $m) { ?>
        <div class="form-group">
            <label for="paymentMethod">
                <input type="checkbox" id="paymentMethod" name="paymentMethod[]" value="<?=$m['payment_method_id']?>">
                <?=$m['name']?>
            </label>
        </div>
        <?php } ?>
    </form>
</div>
