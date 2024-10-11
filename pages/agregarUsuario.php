<?php
session_start(); // Iniciar sesión

function generarUsuario($nombre, $rut)
{
    $primeraLetraNombre = strtolower($nombre[0]);  // Obtener la primera letra del nombre
    $rutSinGuion = str_replace('-', '', $rut);  // Eliminar cualquier guion del rut
    return $primeraLetraNombre . $rutSinGuion;  // Concatenar la primera letra del nombre con el rut completo
}
function generarIdUnico()
{
    return uniqid();
}

// Procesar el formulario de agregar estudiante
if (isset($_POST['submit'])) {
    $idEstudiante = uniqid();
    $rut = $_POST['rut'];
    $nombre = $_POST['nombre'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $numApoderado = $_POST['num_apoderado'];
    $materiasSeleccionadas = $_POST['docentes']; // Materias seleccionadas (IDs de los docentes)


    // Generar el usuario
    $usuario = generarUsuario($nombre, $rut);

    // La contraseña por defecto es "123Tamarindo"
    $contraseña = "123Tamarindo";

    // Formato: idUsuario|rut|nombre|fecha_nacimiento|direccion|celular|usuario|contraseña
    $datos = $idEstudiante . '|' . $rut . '|' . $nombre . '|' . $fechaNacimiento . '|' . $direccion . '|' . $numApoderado . '|' . $usuario . '|' . $contraseña . PHP_EOL;

    // Guardar el estudiante en el archivo
    file_put_contents('../doc/estudiantes.txt', $datos, FILE_APPEND);


    // Ahora guardamos las notas en "notas.txt"
    foreach ($materiasSeleccionadas as $idDocente) {
        $idNota = generarIdUnico(); // Generar un ID único para cada entrada en notas
        $nota1 = "Pendiente";
        $nota2 = "Pendiente";
        $nota3 = "Pendiente";
        // Formato: idNota|idEstudiante|nota1|nota2|nota3|idDocente
        $datosNotas = $idNota . '|' . $idEstudiante . '|' . $nota1 . '|' . $nota2 . '|' . $nota3 . '|' . $idDocente . PHP_EOL;

        // Guardar las notas en el archivo "notas.txt"
        file_put_contents('../doc/notas.txt', $datosNotas, FILE_APPEND);
    }

    // Guardar el mensaje en la sesión
    $_SESSION['message'] = "Estudiante agregado.";
    header("Location: estudiantes.php"); //Redirigir 
    exit();
}
