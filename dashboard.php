<?php
include_once 'funciones_personajes.php';
include_once 'funciones_profesiones.php';
$personajes = listar_personajes();
$profesiones = listar_profesiones();

// Cantidad total de personajes y profesiones
$total_personajes = count($personajes);
$total_profesiones = count($profesiones);

// Promedio de profesiones por personaje
$total_profesiones_por_personaje = 0;
foreach ($personajes as $personaje) {
    $total_profesiones_por_personaje += count($personaje['profesiones']);
}
$promedio_profesiones = $total_personajes > 0 ? $total_profesiones_por_personaje / $total_personajes : 0;

// Edad promedio de los personajes
$edad_total = 0;
$hoy = new DateTime();
foreach ($personajes as $personaje) {
    $fecha_nacimiento = new DateTime($personaje['fecha_nacimiento']);
    $edad_total += $hoy->diff($fecha_nacimiento)->y;
}
$edad_promedio = $total_personajes > 0 ? $edad_total / $total_personajes : 0;

// Profesión con salario más alto y más bajo, y salario promedio
$salario_total = 0;
$salario_max = 0;
$salario_min = PHP_INT_MAX;
$profesion_max = '';
$profesion_min = '';
$personaje_salario_max = '';

foreach ($personajes as $personaje) {
    foreach ($personaje['profesiones'] as $profesion) {
        $salario_total += $profesion['salario'];
        if ($profesion['salario'] > $salario_max) {
            $salario_max = $profesion['salario'];
            $profesion_max = $profesion['nombre'];
            $personaje_salario_max = $personaje['nombre'] . ' ' . $personaje['apellido'];
        }
        if ($profesion['salario'] < $salario_min) {
            $salario_min = $profesion['salario'];
            $profesion_min = $profesion['nombre'];
        }
    }
}
$salario_promedio = $total_profesiones_por_personaje > 0 ? $salario_total / $total_profesiones_por_personaje : 0;

// Datos para el gráfico de distribución de salarios
$categorias = [];
$salarios_por_categoria = [];

foreach ($profesiones as $profesion) {
    $categoria = $profesion['categoria'];
    if (!isset($salarios_por_categoria[$categoria])) {
        $salarios_por_categoria[$categoria] = [];
    }
    $salarios_por_categoria[$categoria][] = $profesion['salario'];
}

$categorias_labels = json_encode(array_keys($salarios_por_categoria));
$salarios_promedio = json_encode(array_map(function ($salarios) {
    return array_sum($salarios) / count($salarios);
}, $salarios_por_categoria));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mundo Barbie</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffe4e1;
            color: #ff1493;
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #d63384;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #ffb6c1;
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
        }
        canvas {
            background: white;
            border-radius: 10px;
            padding: 10px;
        }


        .volvers {
    display: inline-block;
    background-color: #ff69b4;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 20px;
    text-align: center;
}

.contenedor {
    display: flex;
    justify-content: center; 
    align-items: center; 
    height: 30vh; 
}
    </style>
</head>
<body>
    <h2>📊 Panel de Estadísticas</h2>
    <ul>
        <li><b>Total de personajes:</b> <?php echo $total_personajes; ?></li>
        <li><b>Total de profesiones:</b> <?php echo $total_profesiones; ?></li>
        <li><b>Promedio de profesiones por personaje:</b> <?php echo round($promedio_profesiones, 2); ?></li>
        <li><b>Edad promedio de los personajes:</b> <?php echo round($edad_promedio, 2); ?> años</li>
        <li><b>Salario promedio:</b> $<?php echo number_format($salario_promedio, 2); ?></li>
        <li><b>Profesión con el salario más alto:</b> <?php echo $profesion_max; ?> ($<?php echo number_format($salario_max, 2); ?>)</li>
        <li><b>Profesión con el salario más bajo:</b> <?php echo $profesion_min; ?> ($<?php echo number_format($salario_min, 2); ?>)</li>
        <li><b>Personaje con el salario más alto:</b> <?php echo $personaje_salario_max; ?></li>
    </ul>

    <h3>💰 Distribución de Salarios por Categoría de Profesión</h3>
    <canvas id="salaryChart"></canvas>

    <script>
        var ctx = document.getElementById("salaryChart").getContext("2d");
        var salaryChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: <?php echo $categorias_labels; ?>,
                datasets: [{
                    label: "Salario Promedio ($USD)",
                    data: <?php echo $salarios_promedio; ?>,
                    backgroundColor: ["#ff69b4", "#ffcc00", "#00bfff", "#ff5733", "#8e44ad"]
                }]
            }
        });
    </script>

<div class = "contenedor">
<a href="index.php" class = "volvers" > Volver a la pagina de inicio</a>
</div>
</body>
</html>
