<?php

if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];
    $archivo_notas = file("notas.txt");
    $notas_actualizadas = [];
    foreach ($archivo_notas as $linea) {     // Recorrer cada línea del archivo
        $datos = explode("|", trim($linea)); // Separar por el delimitador "|"

        if ($datos[0] == $rut) { // Si se encuentra el registro con el RUT proporcionado
            $datos[1] = "Pendiente"; // Mantener el RUT, pero cambiar las notas a "Pendiente"
            $datos[2] = "Pendiente";
            $datos[3] = "Pendiente";
        }
        $notas_actualizadas[] = implode("|", $datos) . "\n"; // Reconstruir la línea modificada
    }

    session_start(); // Iniciar la sesión
    $_SESSION['message'] = "Notas eliminadas correctamente"; // Almacenar el mensaje en la sesión

    header("Location: notas.php"); // Redirigir a notas.php
    exit();
} else {
    echo "RUT no especificado.";
}
