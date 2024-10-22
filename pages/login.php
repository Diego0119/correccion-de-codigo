<?php
session_start(); // Iniciar la sesión
include '../functions/functions.php';

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
