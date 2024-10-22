<?php 
include '../functions/functions.php';

// Obtener los datos enviados por POST
$student_id = $_POST['student_id'];
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$direccion = $_POST['direccion'];
$num_apoderado = $_POST['num_apoderado'];


 
// Archivo de estudiantes
$archivo = '../doc/estudiantes.txt';
if (file_exists($archivo)) {
    $lineas = file($archivo); // Leer todas las líneas del archivo
    $nuevoContenido = '';

    // Recorrer cada línea
    foreach ($lineas as $linea) {
        $datos = explode('|', $linea);

        // Si coincide el ID, actualizar los datos
        if (trim($datos[0]) == $student_id) {
            $usuario = isset($datos[6]) ? trim($datos[6]) : '';
            // Mantener la contraseña actual, o asignar una por defecto si no existe
            $contraseña = isset($datos[7]) ? trim($datos[7]) : "123Tamarindo";

            // Formato actualizado: idUsuario|rut|nombre|fecha_nacimiento|direccion|num_apoderado|usuario|contraseña
            $nuevaLinea = "$student_id|$rut|$nombre|$fecha_nacimiento|$direccion|$num_apoderado|$usuario|$contraseña\n";
        } else {
            $nuevaLinea = $linea; // Mantener la línea original si no es el estudiante editado
        }
        $nuevoContenido .= $nuevaLinea; // Agregar la línea al nuevo contenido
    }

    // Guardar el nuevo contenido en el archivo
    file_put_contents($archivo, $nuevoContenido);

    // Redirigir o mostrar un mensaje de éxito
    header('Location: estudiantes.php?mensaje=editado');
} else {
    echo "Error: no se pudo encontrar el archivo de estudiantes.";
}
?>
