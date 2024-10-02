
<?php include("header.php"); ?>
<main id="main" class="main">


    <section class="section dashboard ">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Resumen de notas </h2>
        </div>
        <div class="alert alert-primary nopadding mt-2 mb-3" role="alert"><i class="bi bi-gear-fill"> Herramientas de programación</i></div>

        <table id="tablaNotas" class="table table-bordered " cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota 3</th>
                    <th>Promedio</th>
                    <th>Recuperación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
          
                    <?php

                    // Abrir el archivo estudiantes.txt
                    $archivo_estudiantes = fopen("estudiantes.txt", "r");
                    $archivo_notas = file("notas.txt"); // Leer todas las líneas del archivo notas.txt

                    if ($archivo_estudiantes) {
                        // Leer el archivo línea por línea
                        while (($linea_estudiante = fgets($archivo_estudiantes)) !== false) {
                            // Separar los datos por el delimitador '|'
                            $datos_estudiante = explode("|", $linea_estudiante);

                            // Asignar los valores de RUT y Nombre
                            $rut = trim($datos_estudiante[0]);  // Eliminar espacios en blanco
                            $nombre = trim($datos_estudiante[1]);  // Eliminar espacios en blanco

                            // Inicializar variables de notas
                            $nota1 = $nota2 = $nota3 = "N/A"; // Default a "N/A" si no se encuentran notas

                            // Buscar las notas correspondientes al RUT en notas.txt
                            foreach ($archivo_notas as $linea_nota) {
                                $datos_nota = explode("|", trim($linea_nota));

                                // Si el RUT coincide, extraer las notas
                                if ($datos_nota[0] == $rut) {
                                    $nota1 = $datos_nota[1];
                                    $nota2 = $datos_nota[2];
                                    $nota3 = $datos_nota[3];
                                    break; // Terminar la búsqueda una vez que se encuentran las notas
                                }
                            }

                            // Calcular el promedio de las notas si todas están disponibles
                            if ($nota1 !== "Pendiente" && $nota2 !== "Pendiente" && $nota3 !== "Pendiente") {
                                $promedio = ($nota1 + $nota2 + $nota3) / 3;
                                // Formatear el promedio a 2 decimales
                                $promedio = number_format($promedio, 2, '.', '');

                                // Condición para verificar si está reprobado
                                $estado = ($promedio < 4) ? "Reprobado" : "Aprobado";
                            } else {
                                $promedio = "Pendiente"; // Si faltan notas, el promedio es "N/A"
                                $estado = "Pendiente";
                            }

                            // Generar las filas de la tabla con los datos recuperados
                            echo "<tr>
                                    <td>$rut</td>
                                    <td>$nombre</td>
                                    <td>$nota1</td>
                                    <td>$nota2</td>
                                    <td>$nota3</td>
                                    <td>$promedio</td>
                                    <td>$estado</td>
                                    <td>
                                        <abbr title='Editar notas'>
                                            <button type='button' class='btn btn-outline-dark' onclick=\"openEditModal('$rut', '$nombre','$nota1','$nota2','$nota3')\" data-bs-toggle='modal' data-bs-target='#editNotesModal'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                        </abbr>
                                    </td>
                                  </tr>";
                        }
                        // Cerrar el archivo estudiantes.txt
                        fclose($archivo_estudiantes);
                    } else {
                        // Mostrar un mensaje de error si el archivo no se pudo abrir
                        echo "No se pudo abrir el archivo estudiantes.txt.";
                    }
                    ?>

          
            </tbody>
        </table>
    </section>
</main><!-- End #main -->


<!-- Modal para editar las notas -->
<div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="editNotesModalLabel"><i class="bi bi-pencil-square"></i> Editar Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="editarNotas.php">
                    <div class="mb-3">
                        <label for="studentRut" class="form-label">RUT del estudiante</label>
                        <input type="text" class="form-control" id="rut" name="rut" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Nombre del estudiante</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nota1" class="form-label">Nota 1</label>
                        <input type="number" class="form-control" id="nota1" name="nota1" min="1" max="7" step="0.1" >
                    </div>
                    <div class="mb-3">
                        <label for="nota2" class="form-label">Nota 2</label>
                        <input type="number" class="form-control" id="nota2" name="nota2" min="1" max="7" step="0.1" >
                    </div>
                    <div class="mb-3">
                        <label for="nota3" class="form-label">Nota 3</label>
                        <input type="number" class="form-control" id="nota3" name="nota3" min="1" max="7" step="0.1" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="saveNotesButton">Guardar cambios</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>


<?php include("footer.php"); ?>