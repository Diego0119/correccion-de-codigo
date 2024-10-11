<?php include("../header.php"); ?>

<main id="main" class="main">

    <section class="section dashboard ">
        <div class="container mt-4">
            <!-- INICIO Mensajes Exp5 -->
            <?php
            if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                echo '<div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">'
                    . htmlspecialchars($_SESSION['message']) .
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['message']);
            }
            ?>
            <!-- FIN Mensajes Exp5 -->

            <!-- INICIO Texto Exp6  -->
            <h2 class="">Resumen de notas </h2>

            <?php
            // Abrir el archivo de docentes
            $archivo_docentes = fopen("../doc/docentes.txt", "r");
            if ($archivo_docentes) {
                while (($linea = fgets($archivo_docentes)) !== false) {
                    $datos_docente = explode("|", trim($linea));
                    $idDocente = trim($datos_docente[0]); // ID del docente
                    $materia = trim($datos_docente[8]); // Materia

                    // Compara el ID del docente logueado con el ID del docente en el archivo
                    if ($idDocente === $idUsuario) {
                        $materiaDocente = $materia; // Asigna la materia encontrada
                        break; // Termina la búsqueda
                    }
                }
                fclose($archivo_docentes); // Cierra el archivo
            }
            ?>

            <!-- Aquí se muestra la alerta con la materia -->
            <div class="alert alert-primary nopadding mt-2 mb-3" role="alert">
                <i class="bi bi-gear-fill"></i> Materia: <?php echo htmlspecialchars($materiaDocente); ?>
            </div>

            <!-- FIN Texto Exp6  -->

            <!-- INICIO TablaNotas Exp7 -->
            <table id="tablaNotas" class="table table-bordered " cellspacing="0" width="100%">
                <thead>
                    <tr> <!-- encabezados de la tabla -->
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Promedio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener el ID del docente logueado
                    $idUsuario = $_SESSION['idUsuario']; // Debes asegurarte de que este ID se guarda correctamente en la sesión

                    // Abrir archivos
                    $archivo_estudiantes = fopen("../doc/estudiantes.txt", "r");
                    $archivo_notas = file("../doc/notas.txt");

                    if ($archivo_estudiantes === false) {
                        die("Error al abrir el archivo de estudiantes.");
                    }

                    if ($archivo_estudiantes) {
                        while (($linea_estudiante = fgets($archivo_estudiantes)) !== false) {
                            $datos_estudiante = explode("|", $linea_estudiante);
                            $idEstudiante = trim($datos_estudiante[0]); // ID del estudiante
                            $rut = trim($datos_estudiante[1]);  // RUT del estudiante
                            $nombre = trim($datos_estudiante[2]);  // Nombre del estudiante
                            $nota1 = $nota2 = $nota3 = "Pendiente"; // Valores por defecto
                            $notaEncontrada = false; // Bandera para verificar si se encontró una nota

                            // Buscar las notas correspondientes al id del estudiante y verificar que el ID del docente coincide
                            foreach ($archivo_notas as $linea_nota) {
                                $datos_nota = explode("|", trim($linea_nota));

                                // $datos_nota[1] es el ID del estudiante y $datos_nota[5] es el ID del docente
                                if ($datos_nota[1] == $idEstudiante && $datos_nota[5] == $idUsuario) {
                                    // Asigna las notas si coinciden el ID del estudiante y el del docente
                                    $idNota = $datos_nota[0];
                                    $nota1 = $datos_nota[2];
                                    $nota2 = $datos_nota[3];
                                    $nota3 = $datos_nota[4];
                                    $notaEncontrada = true; // Se encontró una nota
                                    break; // Termina la búsqueda para este estudiante
                                }
                            }

                            // Solo mostrar el estudiante si tiene notas del docente actual
                            if ($notaEncontrada) {
                                // Calcular promedio solo si las tres notas son numéricas
                                if (is_numeric($nota1) && is_numeric($nota2) && is_numeric($nota3)) {
                                    $promedio = ($nota1 + $nota2 + $nota3) / 3;
                                    $promedio = number_format($promedio, 2, '.', '');
                                    $estado = ($promedio < 4) ? "Reprobado" : "Aprobado";
                                } else {
                                    $promedio = "Pendiente";
                                    $estado = "Pendiente";
                                }

                                // Generar la fila solo para estudiantes que pertenecen al docente logueado
                                echo "<tr>
                                        <td>$rut</td>
                                        <td>$nombre</td>
                                        <td>$nota1</td>
                                        <td>$nota2</td>
                                        <td>$nota3</td>
                                        <td>$promedio</td>
                                        <td>$estado</td>
                                        <td>
                                            <span title='Editar notas'> 
                                                <button type='button' name='editar' id='editar' class='btn btn-outline-dark' onclick=\"openEditModal('$idEstudiante','$rut', '$nombre','$nota1','$nota2','$nota3','$idUsuario', '$idNota')\" data-bs-toggle='modal' data-bs-target='#editNotesModal'>
                                                    <i class='bi bi-pencil-square'></i>
                                                </button>
                                            </span>
                                            <span title='Eliminar'> 
                                                <a type='button' id='eliminarNotas' name='eliminarNotas' onclick='return eliminarNotas()' href='eliminarNotas.php?id=" . htmlspecialchars($idNota) . "' class='btn btn-outline-danger'><i class='bi bi-trash'></i>
                                                </a>
                                            </span>
                                        </td>
                                     </tr>";
                            }
                        }
                        fclose($archivo_estudiantes); // Cierra el archivo fuera del bucle
                    } else {
                        echo "No se pudo abrir el archivo";
                    }
                    ?>

                </tbody>
            </table>
            <!-- FIN TablaNotas Exp7 -->
        </div>
    </section>
</main>

<!-- INICIO EditarNotas exp8 -->
<div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="editNotesModalLabel"><i class="bi bi-pencil-square"></i> Editar Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="editarNotas.php">
                    <input type="hidden" value="" name="idEstudiante" id="idEstudiante">
                    <input type="hidden" value="" name="idUsuario" id="idUsuario">
                    <input type="hidden" value="" name="idNota" id="idNota">
                    <div class="mb-3">
                        <label for="studentRut" class="form-label">RUT del estudiante</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control" id="rut" name="rut" value="" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Nombre del estudiante</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="studentName" name="studentName" value="" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nota1" class="form-label">Nota 1</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-award"></i></span>
                            <input type="number" class="form-control" id="nota1" name="nota1" min="1" max="7" step="0.1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nota2" class="form-label">Nota 2</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-award"></i></span>
                            <input type="number" class="form-control" id="nota2" name="nota2" min="1" max="7" step="0.1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nota3" class="form-label">Nota 3</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-award"></i></span>
                            <input type="number" class="form-control" id="nota3" name="nota3" min="1" max="7" step="0.1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="GuardarNotas" name="GuardarNotas">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIN EditarNotas exp8 -->

<?php include("../footer.php"); ?>