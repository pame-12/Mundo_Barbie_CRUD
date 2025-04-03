<?php
// Función para registrar un personaje en personajes.json
function registrar_personaje($id, $nombre, $apellido, $fecha_nacimiento, $foto, $profesiones) {
    $personajes = json_decode(file_get_contents('personajes.json'), true) ?? [];
    
    $nuevo_personaje = [
        'id' => $id,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'fecha_nacimiento' => $fecha_nacimiento,
        'foto' => $foto,
        'profesiones' => $profesiones
    ];
    
    $personajes[] = $nuevo_personaje;
    file_put_contents('personajes.json', json_encode($personajes, JSON_PRETTY_PRINT));
}



// Función para listar los personajes registrados
function listar_personajes() {
    return json_decode(file_get_contents('personajes.json'), true) ?? [];
}

// Función para listar las profesiones registradas
function listar_profesiones() {
    return json_decode(file_get_contents('profesiones.json'), true) ?? [];
}

function eliminar_personaje($id) {
    $personajes = json_decode(file_get_contents('personajes.json'), true) ?? [];

    // Filtrar el personaje a eliminar
    $nueva_lista = array_filter($personajes, function ($personaje) use ($id) {
        return $personaje['id'] !== $id;
    });

    // Guardar la nueva lista sin el personaje eliminado
    file_put_contents('personajes.json', json_encode(array_values($nueva_lista), JSON_PRETTY_PRINT));
}

?>
