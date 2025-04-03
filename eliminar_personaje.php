<?php
// Eliminar personajes
include 'funciones_personajes.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    eliminar_personaje($id);

    echo "<script>alert('Personaje eliminado con éxito'); window.location.href='listar_personajes.php';</script>";
} else {
    echo "<script>alert('ID de personaje no encontrado'); window.location.href='listar_personajes.php';</script>";
}
?>
