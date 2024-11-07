<?php
session_start(); // Iniciar la sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: /Notas/index.php");
    exit();
}
$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['nombre'];
$tipoUsuario = $_SESSION['tipo'];
?>

<!DOCTYPE html>
<html lang="en">

<!-- INICIO head Exp1 -->

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>EduScore</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- CSS -->
    <link href="/Notas/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Notas/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="/Notas/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<!-- FIN head Exp1 -->

<body>
    <!--INICIO  Header  Exp2 -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="" class="logo d-flex align-items-center">
                <img src="/Notas/img/logo.png" alt="">
                <span class="d-none d-lg-block">EduScore</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

    </header>
    <!-- End Header Exp2 -->

    <!-- INICIO Sidebar Exp3 -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <div class="text-center">
                <h5 class="text-center fw-bold">Bienvenid@</h5>
                <h6 class="text-center"> <?php echo $nombreUsuario; // Mostrar el nombre del usuario 
                ?> </h6>
            </div>
            <hr>

            <?php if ($tipoUsuario == "admin"): ?>
                <a class="nav-link collapsed" href="/Notas/pages/estudiantes.php">
                    <i class="bi bi-people-fill"></i>
                    <span>Estudiantes</span>
                </a>
            <?php elseif ($tipoUsuario == "docente"): ?>
                <a class="nav-link collapsed" href="/Notas/pages/notas.php">
                    <i class="bi bi-clipboard-minus"></i>
                    <span>Notas</span>
                </a>
            <?php elseif ($tipoUsuario == "estudiante"): ?>
                <a class="nav-link collapsed" href="/Notas/pages/misNotas.php">
                    <i class="bi bi-book"></i>
                    <span>Mis Notas</span>
                </a>
            <?php endif; ?>


            <a class=" nav-link collapsed" href="/Notas/pages/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar sesión</span>
            </a>

        </ul>
    </aside>
    <!-- FIN Sidebar Exp3-->