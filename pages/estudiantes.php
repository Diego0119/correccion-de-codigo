<?php include("../header.php"); ?>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Listado de estudiantes inscritos</h2>
      <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal"
        data-bs-target="#addStudentModal">
        Agregar estudiante
      </button>
    </div>
    <div class="alert alert-primary nopadding mt-2 mb-3" role="alert"><i class="bi bi-gear-fill">Gestión de
        estudiantes</i></div>
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg"> <!-- Hacer el modal más grande con modal-lg -->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #007bff; color: white;">
            <h5 class="modal-title" id="addStudentModalLabel"><i class="bi bi-person-plus"></i> Agregar Estudiante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addStudentForm" method="post" action="agregarUsuario.php">
              <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="rut" class="form-label">Rut del estudiante</label>
                    <div class="form-text mb-2">Ejemplo: <strong>211410884</strong> (sin puntos ni guiones)</div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                      <input type="text" class="form-control" id="rut" name="rut" required maxlength="9">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person"></i></span>
                      <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                      <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>
                  </div>
                </div>
                <!-- Columna derecha -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                      <input type="text" class="form-control" id="direccion" name="direccion" required maxlength="100">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="num_apoderado" class="form-label">Número de apoderado</label>
                    <div class="form-text mb-2">Ejemplo: <strong>912345678</strong> (9 dígitos, comienza con 9)</div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                      <input type="text" class="form-control" id="num_apoderado" name="num_apoderado" required
                        maxlength="9">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="materias" class="form-label">Selecciona las materias a inscribir</label>
                    <div class="row">
                      <?php
                      // Abrir el archivo de docentes
                      $archivo_docentes = fopen("../doc/docentes.txt", "r");

                      if ($archivo_docentes === false) {
                        die("Error al abrir el archivo de docentes.");
                      }

                      // Generar casillas en dos columnas (col-md-6)
                      echo '<div class="col-md-6">'; // Primera columna
                      $i = 0;
                      while (($linea_docente = fgets($archivo_docentes)) !== false) {
                        $datos_docente = explode("|", $linea_docente);
                        $idDocente = trim($datos_docente[0]);
                        $materia = trim($datos_docente[8]);

                        // Generar cada checkbox
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="docentes[]" value="' . htmlspecialchars($idDocente) . '" id="docente' . htmlspecialchars($idDocente) . '">';
                        echo '<label class="form-check-label" for="docente' . htmlspecialchars($idDocente) . '">' . htmlspecialchars($materia) . '</label>';
                        echo '</div>';

                        // Cambiar de columna cada 5 materias
                        if (++$i % 5 === 0) {
                          echo '</div><div class="col-md-6">'; // Iniciar nueva columna
                        }
                      }

                      echo '</div>'; // Cerrar la última columna
                      
                      fclose($archivo_docentes); // Cerrar el archivo
                      ?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" name="submit">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal para editar estudiante -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #007bff; color: white;">
            <h5 class="modal-title" id="editStudentModalLabel"><i class="bi bi-pencil-square"></i> Editar Estudiante
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editStudentForm" method="post" action="editar.Estudiantes.php">
              <input type="hidden" id="edit_student_id" name="student_id">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="edit_rut" class="form-label">Rut del estudiante</label>
                    <div class="form-text mb-2">Ejemplo: <strong>211410884</strong> (sin puntos ni guiones)</div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                      <input type="text" class="form-control" id="edit_rut" name="rut" required maxlength="9">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="edit_nombre" class="form-label">Nombre completo</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person"></i></span>
                      <input type="text" class="form-control" id="edit_nombre" name="nombre" required maxlength="100">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="edit_fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                      <input type="date" class="form-control" id="edit_fecha_nacimiento" name="fecha_nacimiento"
                        required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="edit_direccion" class="form-label">Dirección</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                      <input type="text" class="form-control" id="edit_direccion" name="direccion" required
                        maxlength="100">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="edit_num_apoderado" class="form-label">Número de apoderado</label>
                    <div class="form-text mb-2">Ejemplo: <strong>912345678</strong> (9 dígitos, comienza con 9)</div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                      <input type="text" class="form-control" id="edit_num_apoderado" name="num_apoderado" required
                        maxlength="9">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" name="submit">Guardar cambios</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Procesar el formulario con PHP -->

    <?php
    // Mostrar el mensaje de alerta si hay alguno
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
      echo '<div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">'
        . htmlspecialchars($_SESSION['message']) .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
      unset($_SESSION['message']); // Limpiar el mensaje de la sesión
    }

    if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
      echo '<div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">'
        . htmlspecialchars($_SESSION['error_message']) .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
      unset($_SESSION['error_message']); // Limpiar el mensaje de la sesión
    }
    ?>

    <table id="tabla" class="table table-bordered " cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Rut</th>
          <th>Nombre</th>
          <th>Fecha Nac.</th>
          <th>Dirección</th>
          <th>Número de apoderado</th>
          <th>Materias Inscritas</th> <!-- Nueva columna para las materias -->
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Leer el archivo estudiantes.txt
        $filenameEstudiantes = '../doc/estudiantes.txt';
        $filenameNotas = '../doc/notas.txt'; // Archivo de notas para obtener las materias
        
        if (file_exists($filenameEstudiantes)) {
          $fileEstudiantes = fopen($filenameEstudiantes, 'r');

          // Leer cada línea del archivo de estudiantes
          while (($lineEstudiante = fgets($fileEstudiantes)) !== false) {
            // Separar los datos por el delimitador '|'
            $dataEstudiante = explode('|', $lineEstudiante);

            // Asegurarse de que hay suficientes datos en la línea
            if (count($dataEstudiante) >= 5) {
              $idEstudiante = trim($dataEstudiante[0]); // ID del estudiante
              $rut = htmlspecialchars($dataEstudiante[1]);
              $nombre = htmlspecialchars($dataEstudiante[2]);
              $fechNac = htmlspecialchars($dataEstudiante[3]);
              $direccion = htmlspecialchars($dataEstudiante[4]);
              $num = htmlspecialchars($dataEstudiante[5]);

              // Inicializar variable para almacenar las materias inscritas
              $materiasInscritas = [];

              // Leer el archivo de notas para obtener las materias
              if (file_exists($filenameNotas)) {
                $fileNotas = fopen($filenameNotas, 'r');

                // Leer cada línea del archivo de notas
                while (($lineNota = fgets($fileNotas)) !== false) {
                  $dataNota = explode('|', $lineNota);

                  // Verificar si el ID del estudiante coincide con el del archivo de notas
                  if (count($dataNota) >= 6 && trim($dataNota[1]) == $idEstudiante) {
                    $idDocente = trim($dataNota[5]); // ID del docente que dicta la materia
        
                    // Buscar el nombre de la materia en el archivo de docentes.txt
                    $filenameDocentes = '../doc/docentes.txt';
                    if (file_exists($filenameDocentes)) {
                      $fileDocentes = fopen($filenameDocentes, 'r');

                      while (($lineDocente = fgets($fileDocentes)) !== false) {
                        $dataDocente = explode('|', $lineDocente);

                        if (count($dataDocente) >= 9 && trim($dataDocente[0]) == $idDocente) {
                          $materia = htmlspecialchars($dataDocente[8]); // Materia dictada por el docente
                          $materiasInscritas[] = $materia;
                        }
                      }

                      fclose($fileDocentes); // Cerrar archivo de docentes
                    }
                  }
                }

                fclose($fileNotas); // Cerrar archivo de notas
              }

              // Mostrar los datos del estudiante en la tabla
              echo '<tr>';
              echo '<td>' . $rut . '</td>';
              echo '<td>' . $nombre . '</td>';
              echo '<td>' . $fechNac . '</td>';
              echo '<td>' . $direccion . '</td>';
              echo '<td>' . $num . '</td>';

              // Mostrar las materias inscritas
              echo '<td>';
              if (!empty($materiasInscritas)) {
                echo implode(', ', $materiasInscritas); // Mostrar las materias separadas por comas
              } else {
                echo 'No inscrito en ninguna materia';
              }
              echo '</td>';

              // Acciones
              echo '<td>
            <center>
                             <button class="btn btn-warning btn-sm edit-button" data-bs-toggle="modal" data-bs-target="#editStudentModal" data-id="' . htmlspecialchars($idEstudiante) . '" data-rut="' . htmlspecialchars($rut) . '" data-nombre="' . htmlspecialchars($nombre) . '" data-fecha-nacimiento="' . htmlspecialchars($fechNac) . '" data-direccion="' . htmlspecialchars($direccion) . '" data-num-apoderado="' . htmlspecialchars($num) . '">
                      Editar
                    </button>
            </center>
          </td>';
              echo '</tr>';
            }
          }

          fclose($fileEstudiantes); // Cerrar archivo de estudiantes
        } else {
          echo '<tr><td colspan="7">No se encontró el archivo de estudiantes.</td></tr>';
        }
        ?>
      </tbody>
    </table>

  </section>
</main><!-- End #main -->


<?php include("../footer.php"); ?>