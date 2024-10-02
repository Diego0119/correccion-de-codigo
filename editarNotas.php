<?php
ob_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut = $_POST['rut'];
    // Verificar si cada nota está presente, de lo contrario asignar "Pendiente"
    $nota1 = isset($_POST['nota1']) && !empty($_POST['nota1']) ? floatval($_POST['nota1']) : "Pendiente";
    $nota2 = isset($_POST['nota2']) && !empty($_POST['nota2']) ? floatval($_POST['nota2']) : "Pendiente";
    $nota3 = isset($_POST['nota3']) && !empty($_POST['nota3']) ? floatval($_POST['nota3']) : "Pendiente";
    $notas = file("notas.txt"); // Leer todas las líneas de notas.txt
    $encontrado = false;
    foreach ($notas as $key => $linea) { // Actualizar la línea correspondiente si el RUT ya existe
        $datos = explode("|", trim($linea));
        if ($datos[0] == $rut) {
            $notas[$key] = "$rut|$nota1|$nota2|$nota3\n"; // Actualizar la línea con las nuevas notas o con "Pendiente" si no están
            $encontrado = true;
            break;
        }
    }
    if (!$encontrado) { // Si no se encontró el RUT, agregar una nueva línea con los datos del estudiante
        $notas[] = "$rut|$nota1|$nota2|$nota3\n";
    }
    file_put_contents("notas.txt", implode("", $notas)); // Escribir las líneas actualizadas (o con el nuevo estudiante) de nuevo en el archivo
    session_start(); // Iniciar la sesión
    $_SESSION['message'] = "Notas asignadas correctamente"; // Almacenar el mensaje en la sesión
    
    header("Location: notas.php");
    exit();
}


ob_end_flush();
?>


