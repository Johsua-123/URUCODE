<?php 
    session_start();

    if (!isset($_SESSION["code"])) {
        header("Location: ../index.php");
        exit();
    }

    $location = "index";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/module.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/sidebar.css">
    <link rel="stylesheet" href="assets/styles/graficas.css">
    <title>Inicio| Errea Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "reusables/sidebar.php"; ?>
        <?php include "reusables/navbar.php"; ?>
        <main>
        <div class="container">
        <header class="header">
            <div class="box">
                <h2>12,361</h2>
                <p>Emails Enviados</p>
            </div>
            <div class="box">
                <h2>431,225</h2>
                <p>Ventas Totales</p>
            </div>
            <div class="box">
                <h2>32,441</h2>
                <p>Nuevos Clientes</p>
            </div>
            <div class="box">
                <h2>1,325,134</h2>
                <p>Traffico Total</p>
            </div>
        </header>

        <section class="section">
            <div class="box full-width">
                <h2>Usuarios Registrados</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="box small-box">
                <h2>Ingresos Por Servicios</h2>
                <canvas id="campaignChart"></canvas>
            </div>
            <div class="box small-box">
                <h2>Cantidad De Ventas</h2>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="box full-width">
                <h2>Transaciones Recientes</h2>
                <ul>
                    <li>01e4dsa - Facundo Bisio - $43.95</li>
                    <li>0315dsaa - Mateo Severo - $133.45</li>
                    <li>01e4dsa - Johsua Hartwig - $43.95</li>
                    <li>51034szv - Juan Cruz- $123.50</li>
                </ul>
            </div>
            <div class="box full-width">
                <h2>ERREA ADMIN</h2>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Registros',
                    data: [300, 200, 400, 300, 200, 100, 500],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });

        var ctxCampaign = document.getElementById('campaignChart').getContext('2d');
        var campaignChart = new Chart(ctxCampaign, {
            type: 'doughnut',
            data: {
                labels: ['Venta de Hardware', 'Soporte Tecnico', 'Consultoria', 'Desarrolo de Software', 'Mantenimiento'],
                datasets: [{
                    data: [15942, 8023, 3883, 10932, 13821],
                    backgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 23, 221, 1)', 'rgba(321, 23, 2, 1)', 'rgba(2, 99, 132, 1)']
                }]
            }
        });

        var ctxSales = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Ventas',
                    data: [2000, 4000, 8000, 16000, 20000, 30000, 35000, 36000, 38000, 42000, 50000, 70000],
                    backgroundColor: 'rgba(153, 102, 255, 1)'
                }]
            }
        });

    </script>
</body>
</html>
