<?php
include 'funciones_personajes.php';

// Verificar si se recibió un ID válido
if (!isset($_GET['id'])) {
    echo "Error: No se recibió un ID válido.";
    exit;
}

$id = $_GET['id'];
$personajes = listar_personajes();
$personaje = null;

// Buscar el personaje en la lista
foreach ($personajes as $p) {
    if ($p['id'] === $id) {
        $personaje = $p;
        break;
    }
}

if (!$personaje) {
    echo "Error: Personaje no encontrado.";
    exit;
}

// Guardar cambios cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $personaje['nombre'] = $_POST['nombre'];
    $personaje['apellido'] = $_POST['apellido'];
    $personaje['fecha_nacimiento'] = $_POST['fecha_nacimiento'];
    $personaje['foto'] = $_POST['foto'];

    // Actualizar profesiones
    $nuevas_profesiones = [];
    if (!empty($_POST['profesiones']) && !empty($_POST['salarios'])) {
        for ($i = 0; $i < count($_POST['profesiones']); $i++) {
            $nuevas_profesiones[] = [
                "nombre" => trim($_POST['profesiones'][$i]),
                "salario" => (float)$_POST['salarios'][$i]
            ];
        }
    }
    $personaje['profesiones'] = $nuevas_profesiones;

    // Guardar en el JSON
    foreach ($personajes as &$p) {
        if ($p['id'] === $id) {
            $p = $personaje;
            break;
        }
    }
    file_put_contents('datos/personajes.json', json_encode($personajes, JSON_PRETTY_PRINT));

    echo "<script>alert('Personaje actualizado con éxito'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personaje - Mundo Barbie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffccff;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #ff1493;
        }
        .container {
            max-width: 600px;
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
        .remove-btn {
            color: red;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
    <script>
        function agregarProfesion() {
            let container = document.getElementById('profesionesContainer');
            let div = document.createElement('div');
            div.classList.add('mb-3', 'profesion-item');
            div.innerHTML = `
                <input type="text" name="profesiones[]" class="form-control mb-2" placeholder="Nombre de la Profesión" required>
                <input type="number" name="salarios[]" class="form-control mb-2" placeholder="Salario en USD" required>
                <span class="remove-btn" onclick="this.parentElement.remove()">❌</span>
            `;
            container.appendChild(div);
        }
    </script>
</head>
<body>

<div class="container">
    <h2 class="text-center">✏️ Editar Personaje ✏️</h2>
    <form action="editar_personaje.php?id=<?php echo $id; ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $personaje['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido:</label>
            <input type="text" name="apellido" class="form-control" value="<?php echo $personaje['apellido']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo $personaje['fecha_nacimiento']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto URL:</label>
            <input type="text" name="foto" class="form-control" value="<?php echo $personaje['foto']; ?>" required>
        </div>
        
        <h4>💼 Profesiones y Salarios</h4>
        <div id="profesionesContainer">
            <?php foreach ($personaje['profesiones'] as $profesion): ?>
                <div class="mb-3 profesion-item">
                    <input type="text" name="profesiones[]" class="form-control mb-2" value="<?php echo $profesion['nombre']; ?>" required>
                    <input type="number" name="salarios[]" class="form-control mb-2" value="<?php echo $profesion['salario']; ?>" required>
                    <span class="remove-btn" onclick="this.parentElement.remove()">❌</span>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary w-100" onclick="agregarProfesion()">➕ Agregar Profesión</button>

        <button type="submit" class="btn btn-barbie w-100 mt-3">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
