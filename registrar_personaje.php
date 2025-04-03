<?php
include 'funciones_personajes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid();
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    
    // Guardar la imagen subida
    // Verificar si hay una imagen subida
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    // Asegurar que la carpeta 'img' existe
    if (!is_dir('img')) {
        mkdir('img', 0777, true);
    }

    // Obtener el nombre del archivo, limpiar espacios y caracteres especiales
    $nombre_archivo = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['foto']['name']));
    
    // Definir la ruta asegurando que usa '/'
    $ruta_destino = "img/" . $nombre_archivo;
    $ruta_destino = str_replace("\\", "/", $ruta_destino);

    // Intentar mover la imagen al destino
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
        $foto = $ruta_destino; // Guardar la ruta en la variable
    } else {
        $foto = "img/default.png"; // Si hay error, usar la imagen por defecto
    }
} else {
    $foto = "img/default.png"; // Si no se sube imagen, usar la imagen por defecto
}





    // Procesar profesiones y salarios
    $profesiones = [];
    if (!empty($_POST['profesiones']) && !empty($_POST['salarios'])) {
        for ($i = 0; $i < count($_POST['profesiones']); $i++) {
            $profesiones[] = [
                "nombre" => trim($_POST['profesiones'][$i]),
                "salario" => (float)$_POST['salarios'][$i]
            ];
        }
    }

    registrar_personaje($id, $nombre, $apellido, $fecha_nacimiento, $foto, $profesiones);
    echo "<script>alert('Personaje registrado con éxito'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Personaje - Mundo Barbie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     
    <!-- Diseno de la pagina
-->
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
    <!-- Creacion del formulario de registro
-->
    <h2 class="text-center">👩‍🎤 Registrar Personaje 👩‍🎤</h2>
    <form action="registrar_personaje.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto :</label>
            <input type="file" name="foto" class="form-control" required>
        </div>
        
        <h4>💼 Profesiones y Salarios</h4>
        <div id="profesionesContainer"></div>
        <button type="button" class="btn btn-secondary w-100" onclick="agregarProfesion()">➕ Agregar Profesión</button>
        
        <button type="submit" class="btn btn-barbie w-100 mt-3">Guardar Personaje</button>
    </form>
</div>

</body>
</html>

