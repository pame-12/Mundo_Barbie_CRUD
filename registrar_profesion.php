<?php
include 'funciones_profesiones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_profesion = $_POST['nombre_profesion'];
    $categoria = $_POST['categoria'];
    $nivel_experiencia = $_POST['nivel_experiencia'];
    $salario = $_POST['salario'];

    registrar_profesion($nombre_profesion, $categoria, $nivel_experiencia, $salario);
    echo "<script>alert('Profesión registrada con éxito'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Profesión - Mundo Barbie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffccff;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #ff1493;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">💼 Registrar Profesión 💼</h2>
    <form action="registrar_profesion.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre de la Profesión:</label>
            <input type="text" name="nombre_profesion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría:</label>
            <select name="categoria" class="form-control" required>
                <option value="Ciencia">Ciencia</option>
                <option value="Arte">Arte</option>
                <option value="Deporte">Deporte</option>
                <option value="Entretenimiento">Entretenimiento</option>
                <option value="Salud">Salud</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nivel de Experiencia:</label>
            <select name="nivel_experiencia" class="form-control" required>
                <option value="Principiante">Principiante</option>
                <option value="Intermedio">Intermedio</option>
                <option value="Avanzado">Avanzado</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Salario Mensual ($USD):</label>
            <input type="number" name="salario" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-barbie w-100">Guardar Profesión</button>
    </form>
</div>

</body>
</html>
