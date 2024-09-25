<form action="" method="post">

<div class="container p-4">
      <h1>Campos a agregar</h1>    
        <div class="form-group">
          <label for="input-type">Selecciona el tipo de campo:</label>
          <select id="typeInput" class="form-select" name="typeInput">
            <option value="text">Texto / Numerico </option>
            <option value="file">Archivos</option>
          </select>
        </div>
        <div class="form-group">
          <label for="input-count">Selecciona la cantidad:</label>
          <input type="number" id="quantityInput" class="form-control" name="quantity" value="1" min="1" max="10">
        </div>
        <div class="col-md-3 pt-3">
            <button id="AddinputsOrder" type="button" data-url="<?=Helpers\generateUrl("Order","Order","addInputsFormAjax",[],"ajax");?>"class="btn btn-outline-primary" >Agregar Campos</button>
        </div>
    </div>
</form>
