<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="/Notas/css/style.css" rel="stylesheet">
</head>

<body class="login-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card card shadow-lg">
                    <div class="card-body">
                        <center><i class="fa-solid fa-circle-user fa-4x "></i></center>
                        <h2 class="text-center mb-4">Login</h2>
                        <form action="pages/login.php" method="POST">
                            <div class="mb-3">
                                <label for="user" class="login-form-label">Usuario</label>
                                <div class="input-group login-input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="user" id="user" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="login-form-label">Contraseña</label>
                                <div class="input-group login-input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="login-form-label">Tipo de usuario</label>
                                <div class="radio-group-unique text-center">
                                    <div class="form-check-unique">
                                        <input class="form-check-input-unique" type="radio" name="tipo" id="estudiante" value="estudiante" required>
                                        <label class="form-check-label-unique" for="estudiante">Estudiante</label>
                                    </div>
                                    <div class="form-check-unique">
                                        <input class="form-check-input-unique" type="radio" name="tipo" id="docente" value="docente" required>
                                        <label class="form-check-label-unique" for="docente">Docente</label>
                                    </div>
                                    <div class="form-check-unique">
                                        <input class="form-check-input-unique" type="radio" name="tipo" id="admin" value="admin" required>
                                        <label class="form-check-label-unique" for="admin">Admin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn login-btn">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>