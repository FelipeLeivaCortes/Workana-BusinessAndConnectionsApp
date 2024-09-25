<?php foreach ($seller as $s) {

?>
<div class="container p-4">
    <h2>Actualizar vendedor</h2>
    <form action="<?= Helpers\generateUrl("Clients","Clients","SellerUpdate")?>" method="POST">
        <input type="hidden" class="form-control" id="s_id" value="<?=$s['s_id']?>" name="s_id" required>
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="s_name" value="<?=$s['s_name']?>" name="s_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="s_email" name="s_email" value="<?=$s['s_email']?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Teléfono:</label>
            <input type="text" class="form-control" id="s_phone" name="s_phone" value="<?=$s['s_phone']?>" required>
        </div>
        <div class="form-group">
            <label for="city">Código:</label>
            <input type="text" class="form-control" id="s_code" name="s_code" value="<?=$s['s_code']?>" required>
        </div>
        <div class="form-group p-2">

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>

    </form>
</div>
<?php }
?>