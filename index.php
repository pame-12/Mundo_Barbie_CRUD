<?php
// Página principal del Sistema de Gestión del Mundo Barbie
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión del Mundo Barbie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffccff;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #ff1493;
        }
        .navbar {
            background-color: #ff69b4;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .btn-barbie {
            background-color: #ff69b4;
            color: white;
            font-weight: bold;
            border-radius: 20px;
        }
        .btn-barbie:hover {
            background-color: #ff1493;
        }

        .img-fluid{
            width: 900px;
            height: 600px;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">🌸 Mundo Barbie 🌸</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="registrar_personaje.php">Registrar Personaje</a></li>
                <li class="nav-item"><a class="nav-link" href="registrar_profesion.php">Registrar Profesión</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_personajes.php">Ver Personajes</a></li>
                <li class="nav-item"><a class="nav-link" href="dashboard.php">📊 Estadísticas</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>💖 ¡Bienvenida al Sistema de Gestión del Mundo Barbie! 💖</h1>
    <p>Administra personajes, profesiones y descubre estadísticas sobre el mundo Barbie.</p>
    <img src="img/barbie_welcome.png.jpg" alt="Bienvenida Barbie" class="img-fluid">
    <br><br>
    <a href="registrar_personaje.php" class="btn btn-barbie btn-lg">Registrar un Personaje</a>
</div>

</body>
</html>
