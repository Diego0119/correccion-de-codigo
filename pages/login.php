<?php
session_start(); // Iniciar la sesión

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

// Validar las credenciales del usuario y recuperar el ID y el nombre
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

// Obtener los datos del formulario
$user = $_POST['user'];
$password = $_POST['password'];
$tipo = $_POST['tipo'];

// Determinar qué archivo leer
$archivo = obtenerArchivoPorTipo($tipo);

// Variables para almacenar el ID y el nombre del usuario
$idUsuario = null;
$nombre = null;

if ($archivo !== null && validarUsuario($user, $password, $archivo, $idUsuario, $nombre)) {
    // Almacenar en sesión el ID y el nombre del usuario
    $_SESSION['idUsuario'] = $idUsuario;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['tipo'] = $tipo;

    // Redirigir según el tipo de usuario
    if ($tipo === 'admin') {
        echo '<script>
                window.location.href = "estudiantes.php";
              </script>';
    } elseif ($tipo === 'docente') {
        echo '<script>
                window.location.href = "notas.php";
              </script>';
    } elseif ($tipo === 'estudiante') {
        echo '<script>
                window.location.href = "misNotas.php";
              </script>';
    }
    exit();
} else {
    // Si la validación falla, mostrar un mensaje de error y redirigir a "index.php"
    echo '<script>
            alert("Usuario o contraseña incorrectos.");
            window.location.href = "../index.php";
          </script>';
    exit();
}
?>
