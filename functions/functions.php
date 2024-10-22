<?php
// Función para generar el nombre de usuario basado en el nombre y el RUT
function generarUsuario($nombre, $rut)
{
    $primeraLetraNombre = strtolower($nombre[0]);  // Obtener la primera letra del nombre
    $rutSinGuion = str_replace('-', '', $rut);  // Eliminar cualquier guion del rut
    return $primeraLetraNombre . $rutSinGuion;  // Concatenar la primera letra del nombre con el rut completo
}

// Función para generar un ID único
function generarIdUnico()
{
    return uniqid();
}

// Función para leer el archivo correcto según el tipo de usuario
function obtenerArchivoPorTipo($tipo) {
    switch ($tipo) {
        case 'estudiante':
            return '../doc/estudiantes.txt';
        case 'docente':
            return '../doc/docentes.txt';
        case 'admin':
            return '../doc/admins.txt';
        default:
            return null;
    }
}

// Función para validar las credenciales del usuario y recuperar el ID y el nombre
function validarUsuario($user, $password, $archivo, &$idUsuario, &$nombre) {
    if (file_exists($archivo)) {
        $file = fopen($archivo, "r");
        while (($line = fgets($file)) !== false) {
            // Separar la línea en campos
            list($id, $rut, $name, $fecha_nacimiento, $direccion, $celular, $usuario, $contraseña) = explode("|", trim($line));

            // Validar si el usuario y la contraseña son correctos
            if ($usuario === $user && $contraseña === $password) {
                $idUsuario = $id;  // Asignar el ID del usuario
                $nombre = $name;  // Asignar el nombre del usuario
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}
function obtenerNotasEstudiante($idEstudiante) {
    $archivoNotas = '../doc/notas.txt'; // Ruta al archivo de notas
    $archivoDocentes = '../doc/docentes.txt'; // Ruta al archivo de docentes
    $notasEstudiante = []; // Array para almacenar las notas

    if (file_exists($archivoNotas)) {
        $archivo = fopen($archivoNotas, "r"); // Abrir el archivo de notas en modo lectura

        // Leer cada línea del archivo de notas
        while (($linea = fgets($archivo)) !== false) {
            list($idNota, $idEstudianteArchivo, $nota1, $nota2, $nota3, $idProfesor) = explode('|', trim($linea));

            // Verificar si las notas pertenecen al estudiante logueado
            if ($idEstudianteArchivo == $idEstudiante) {
                // Obtener la asignatura y el nombre del profesor
                $profesor = obtenerDatosProfesor($idProfesor, $archivoDocentes);

                // Agregar los datos a la lista de notas del estudiante
                $notasEstudiante[] = [
                    'nota1' => $nota1,
                    'nota2' => $nota2,
                    'nota3' => $nota3,
                    'asignatura' => $profesor['asignatura'],
                    'profesor' => $profesor['nombre']
                ];
            }
        }

        fclose($archivo); // Cerrar el archivo de notas
    }

    return $notasEstudiante; // Devolver las notas del estudiante
}

// Función para obtener el nombre del profesor y la asignatura por su ID
function obtenerDatosProfesor($idProfesor, $archivoDocentes) {
    if (file_exists($archivoDocentes)) {
        $archivo = fopen($archivoDocentes, "r"); // Abrir el archivo de docentes en modo lectura

        // Leer cada línea del archivo de docentes
        while (($linea = fgets($archivo)) !== false) {
            list($idDocente, , $nombre, , , , , , $asignatura) = explode('|', trim($linea));

            // Verificar si es el docente correcto
            if ($idDocente == $idProfesor) {
                fclose($archivo); // Cerrar el archivo
                return ['nombre' => $nombre, 'asignatura' => $asignatura];
            }
        }

        fclose($archivo); // Cerrar el archivo
    }

    return ['nombre' => 'Desconocido', 'asignatura' => 'Desconocida'];
}

?>
