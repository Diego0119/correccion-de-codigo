<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstudiante = $_POST['idEstudiante']; //Recupera el id del estudiante mandado desde el botón
    // Verificar si cada nota está presente, de lo contrario asignar "Pendiente"
    $nota1 = isset($_POST['nota1']) && !empty($_POST['nota1']) ? floatval($_POST['nota1']) : "Pendiente";
    $nota2 = isset($_POST['nota2']) && !empty($_POST['nota2']) ? floatval($_POST['nota2']) : "Pendiente";
    $nota3 = isset($_POST['nota3']) && !empty($_POST['nota3']) ? floatval($_POST['nota3']) : "Pendiente";
    $notas = file("../doc/notas.txt"); // Leer todas las líneas de notas.txt
    $encontrado = false;
    foreach ($notas as $key => $linea) { // Actualizar la línea correspondiente si el id$idEstudiante ya existe
        $datos = explode("|", trim($linea));
        if (trim($datos[1]) == trim($idEstudiante)) { // Compara el ID del estudiante
            // Actualiza la línea con las notas, conservando el ID original
            $notas[$key] = "{$datos[0]}|$idEstudiante|$nota1|$nota2|$nota3\n"; // Aquí aseguramos que se usa $datos[0]
            $encontrado = true; // Marcamos como encontrado
            break; // Salimos del bucle
        }
    }
    if (!$encontrado) { // Si no se encontró el id, agregar una nueva línea con los datos del estudiante
        $id = uniqid();
        $notas[] = "$id|$idEstudiante|$nota1|$nota2|$nota3\n";
    }
    file_put_contents("../doc/notas.txt", implode("", $notas)); // Escribir las líneas actualizadas (o con el nuevo estudiante) de nuevo en el archivo
    session_start(); // Iniciar la sesión
    $_SESSION['message'] = "Notas asignadas"; // Almacenar el mensaje en la sesión
    header("Location: notas.php"); //Redirigir a notas.php
    exit();
}

?>


