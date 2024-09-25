<?php foreach ($article as $ar) { ?>

<div class="container p-4">
  <div class="card mb-4">
    <div class="row no-gutters">
      <div class="col-md-6">
        <img src="<?= $ar['ar_img_url'] ?>" alt="<?= $ar['ar_name'] ?>" class="card-img">
      </div>
      <div class="col-md-6">
        <div class="card-body">
          <h1 class="card-title"><?= $ar['ar_name'] ?></h1>
          <p class="card-text"><?= substr($ar['ar_desc'], 0, 100) . 'Ver más...' ?></p> <!-- Trunca a 100 caracteres -->
          <hr>
          <h3 class="card-subtitle">Precio: $<?= $priceArticle[0]['p_value'] ?></h3>
          <p class="card-text">Cantidad disponible: <?= $stockArticle[0]['stock_Quantity'] ?></p>
          <a href="<?php echo $ar['ar_data_url'] ?>" target="_blank" class="btn btn-primary btn-lg">Ficha técnica</a>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <h4>Características:</h4>
          <?php
          $characteristicsList = explode(';',  $ar['ar_characteristics']);
          echo '<ul>';
          foreach ($characteristicsList as $characteristic) {
              echo '<li>' . $characteristic . '</li>';
          }
          echo '</ul>';
          ?>
        </div>
        <div class="col-md-6">
          <h4>Opiniones:</h4>
          <p>No hay opiniones aún.</p>
          <!-- <a href="#" class="btn btn-outline-primary">Escribe una opinión</a> -->
        </div>
      </div>
    </div>
  </div>
</div>

<?php } ?>
