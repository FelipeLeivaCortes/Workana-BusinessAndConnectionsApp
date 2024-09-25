
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h1 class="mb-0">Importar Artículos</h1>
    </div>
    <div class="card-body">
      <form action="<?php echo Helpers\generateUrl("Data", "Data", "ImportArticlesExe") ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="excel_file">Selecciona un archivo Excel:</label>
          <input type="file" class="form-control-file" name="excel_file" id="excel_file">
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
      </form>
    </div>
  </div>
</div>


<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h1 class="mb-0">Importar Clientes</h1>
    </div>
    <div class="card-body">
      <form action="<?php echo Helpers\generateUrl("Data", "Data", "ImportClientsExe") ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="excel_file">Selecciona un archivo Excel:</label>
          <input type="file" class="form-control-file" name="excel_file" id="excel_file">
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
      </form>
    </div>
  </div>
</div>

