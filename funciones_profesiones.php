<?php
$archivo_profesiones = 'profesiones.json'; // Ruta donde se guardarán las profesiones

// Función para obtener todas las profesiones desde el JSON
function obtener_profesiones() {
    global $archivo_profesiones;
    if (!file_exists($archivo_profesiones)) {
        return []; // Si no existe, retorna un array vacío
    }
    $datos_json = file_get_contents($archivo_profesiones);
    return json_decode($datos_json, true) ?: []; 
}

// Función para registrar una nueva profesión
function registrar_profesion($nombre_profesion, $categoria, $nivel_experiencia, $salario) {
    global $archivo_profesiones;
    
    $profesiones = obtener_profesiones(); // Carga las profesiones actuales
    
    // Crear la estructura de la nueva profesión
    $nueva_profesion = [
        "id" => uniqid(),
        "nombre" => $nombre_profesion,
        "categoria" => $categoria,
        "nivel_experiencia" => $nivel_experiencia,
        "salario" => (float)$salario
    ];
    
    // Agregar la nueva profesión al array
    $profesiones[] = $nueva_profesion;
    
    // Guardar el nuevo array en el archivo JSON
    file_put_contents($archivo_profesiones, json_encode($profesiones, JSON_PRETTY_PRINT));
}

// Función para obtener una profesión por ID
function obtener_profesion_por_id($id) {
    $profesiones = obtener_profesiones();
    foreach ($profesiones as $profesion) {
        if ($profesion["id"] === $id) {
            return $profesion;
        }
    }
    return null; // Retorna null si no se encuentra la profesión
}

// Función para eliminar una profesión
function eliminar_profesion($id) {
    global $archivo_profesiones;
    
    $profesiones = obtener_profesiones();
    $profesiones = array_filter($profesiones, function($profesion) use ($id) {
        return $profesion["id"] !== $id;
    });
    
    file_put_contents($archivo_profesiones, json_encode(array_values($profesiones), JSON_PRETTY_PRINT));
}

// Función para actualizar una profesión
function actualizar_profesion($id, $nombre, $categoria, $nivel, $salario) {
    global $archivo_profesiones;
    
    $profesiones = obtener_profesiones();
    
    foreach ($profesiones as &$profesion) {
        if ($profesion["id"] === $id) {
            $profesion["nombre"] = $nombre;
            $profesion["categoria"] = $categoria;
            $profesion["nivel_experiencia"] = $nivel;
            $profesion["salario"] = (float)$salario;
            break;
        }
    }
    
    file_put_contents($archivo_profesiones, json_encode($profesiones, JSON_PRETTY_PRINT));
}
?>
