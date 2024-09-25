
<div class="container p-4">
  <div class="row">
    <div class="col-md-6">
      <img src="<?= $article->images[0]->src ?>" alt="<?= $article->name ?>" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h1><?= $article->name ?></h1>
      <p class="lead"><?= $article->short_description ?></p>
      <hr>
      <h3>Precio: <?= $article->price_html ?></h3>
      <p>Cantidad disponible: <?= $article->purchasable ?></p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <h4>Características:</h4>
      <?=
       $article->description
      ?>
    </div>
    <div class="col-md-6">
      <h4>Opiniones:</h4>
      <p>No hay opiniones aún.</p>
      <!-- <a href="#" class="btn btn-outline-primary">Escribe una opinión</a> -->
    </div>
  </div>
</div>

