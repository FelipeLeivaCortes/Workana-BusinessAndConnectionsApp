<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h1 class="mb-0">Exportar Artículos</h1>
    </div>
    <div class="card-body">
      <form action="<?php echo Helpers\generateUrl("Data", "Data", "ExportArticlesExe",[],"ajax") ?>" method="POST">
        <div class="form-group">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Exportar</button>
      </form>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h1 class="mb-0">Exportar Clientes</h1>
    </div>
    <div class="card-body">
      <form action="<?php echo Helpers\generateUrl("Data", "Data", "ExportClientsExe",[],"ajax") ?>" method="POST">
        <div class="form-group">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Exportar</button>
      </form>
    </div>
  </div>
</div>