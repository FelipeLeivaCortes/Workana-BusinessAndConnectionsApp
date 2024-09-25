<div class="container p-4">
    <h1>Actualizar Plan de Suscripción</h1>
    <form action="<?php echo Helpers\generateUrl("Clients","Clients","updatePlan")?>" method="POST">
        <?php foreach ($plan as $p) { ?>
            <div class="form-group">
                <label for="empresa">Empresa:</label>
                <input type="text" class="form-control" id="empresa" readonly value="<?= $p['company'][0]['c_name'] ?>">
            </div>
            <div class="form-group">
                <label for="plan">Fecha inicial:</label>
                <input type="date" class="form-control" name="date_init" id="date_init" value="<?= $p['subs_date_init'] ?>">
                <label for="plan">Fecha final:</label>
                <input type="date" class="form-control" name="date_end" id="date_end" value="<?= $p['subs_date_end'] ?>" min="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
                <label for="duracion">Duración del plan:</label>
                <select class="form-control" name="duracion" id="duracion" onchange="actualizarContador()">
                    <option value="3">3 meses</option>
                    <option value="6">6 meses</option>
                    <option value="12">1 año</option>
                </select>
            </div>
            <div id="contador"></div>
        <?php } ?>
        <input type="hidden" name="u_email" value="<?=$data['u_email']?>">
        <input type="hidden" name="id_subs" value="<?= $p['id_subs'] ?>">
        <button type="submit" class="btn btn-outline-primary">Actualizar Plan</button>
    </form>
</div>

<script>
    var fechaFinalizacion = '<?= $p['subs_date_end'] ?>';

    function calcularDiferenciaFechas(fechaInicio, fechaFin) {
        var diff = new Date(fechaFin) - new Date(fechaInicio);
        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
        var months = Math.floor(days / 30) % 12;
        var years = Math.floor(days / 365);

        return { days: days, months: months, years: years };
    }

    function actualizarContador() {
        var fechaInicio = document.getElementById("date_init").value;
        var duracion = parseInt(document.getElementById("duracion").value);
        
        var fechaFin = new Date(fechaInicio);
        fechaFin.setMonth(fechaFin.getMonth() + duracion);
        
        var diferenciaFechas = calcularDiferenciaFechas(fechaInicio, fechaFin.toISOString().split('T')[0]);
        
        var contadorElement = document.getElementById("contador");
        contadorElement.innerHTML = "Faltan " + diferenciaFechas.days + " días, " + diferenciaFechas.months + " meses y " + diferenciaFechas.years + " años para que termine la suscripción.";

        // Actualizar fechas en los input date
        document.getElementById("date_end").value = fechaFin.toISOString().split('T')[0];
    }

    document.getElementById("date_init").addEventListener("change", actualizarContador);
    document.getElementById("date_end").addEventListener("change", actualizarContador);
    document.getElementById("duracion").addEventListener("change", actualizarContador);

    actualizarContador();
</script>
