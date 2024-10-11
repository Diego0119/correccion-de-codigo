<?php
if (isset($_GET['id'])) { //Revisamos si se cuenta con el id
    $id = $_GET['id']; //Recuperamos id
    $archivoNotas = file("../doc/notas.txt"); //Obtenemos archivo
    $notasActualizadas = [];
    foreach ($archivoNotas as $linea) {     // Recorrer cada línea del archivo
        $datos = explode("|", trim($linea)); // Separar por el delimitador "|"
        if ($datos[0] == $id) { // Si se encuentra el registro con el id proporcionado
            $datos[2] = "Pendiente"; // Mantener el RUT, pero cambiar las notas a "Pendiente"
            $datos[3] = "Pendiente";
            $datos[4] = "Pendiente";
        }

        $notasActualizadas[] = implode("|", $datos) . "\n"; // Reconstruir la línea modificada
        file_put_contents("../doc/notas.txt", $notasActualizadas); //Guardar cambios
    }

    session_start(); // Iniciar la sesión
    $_SESSION['message'] = "Notas eliminadas"; // Almacenar el mensaje en la sesión
    header("Location: notas.php"); // Redirigir a notas.php
    exit();
} else {
    echo "id no especificado.";
}
