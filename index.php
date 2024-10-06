<?php include("header.php"); ?>
<main id="main" class="main">
  <section class="section dashboard">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Listado de estudiantes inscritos al curso</h2>
      <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Agregar estudiante
      </button>
    </div>
    <div class="alert alert-primary nopadding mt-2 mb-3" role="alert"><i class="bi bi-gear-fill"> Herramientas de programación</i></div>


    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #007bff; color: white;">
            <h5 class="modal-title" id="addStudentModalLabel"><i class="bi bi-person-plus"></i> Agregar Estudiante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="">
              <div class="mb-3">
                <label for="rut" class="form-label">Rut del estudiante</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                  <input type="text" class="form-control" id="rut" name="rut" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                  <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                  <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="num_apoderado" class="form-label">Número de apoderado</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                  <input type="text" class="form-control" id="num_apoderado" name="num_apoderado" required>
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
    if (isset($_POST['submit'])) {
      $idEstudiante = uniqid();
      $rut = $_POST['rut'];
      $nombre = $_POST['nombre'];
      $fechaNacimiento = $_POST['fecha_nacimiento'];
      $direccion = $_POST['direccion'];
      $numApoderado = $_POST['num_apoderado'];
      $idCalificaciones  = uniqid();

      $datos = $idEstudiante. '|' . $rut . '|' . $nombre . '|' . $fechaNacimiento . '|' . $direccion . '|' . $numApoderado . '|' . "Activo" . PHP_EOL;
      $datosCalificaciones = $idCalificaciones. '|' . $idEstudiante. '|' ."Pendiente" . '|' ."Pendiente". '|' ."Pendiente". PHP_EOL;
      file_put_contents('doc/estudiantes.txt', $datos, FILE_APPEND);
      file_put_contents('doc/notas.txt', $datosCalificaciones, FILE_APPEND);


      echo "<div class='alert alert-success mt-3'>Estudiante agregado exitosamente</div>";
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
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Leer el archivo estudiantes.txt
        $filename = 'doc/estudiantes.txt';
        if (file_exists($filename)) {
          $file = fopen($filename, 'r');

          // Leer cada línea del archivo
          while (($line = fgets($file)) !== false) {
            // Separar los datos por el delimitador '|'
            $data = explode('|', $line);

            // Asegurarse de que hay suficientes datos en la línea
            if (count($data) >= 5) {
              $rut = htmlspecialchars($data[1]);
              $nombre = htmlspecialchars($data[2]);
              $direccion = htmlspecialchars($data[3]);
              $fechNac = htmlspecialchars($data[4]);
              $num = htmlspecialchars($data[5]);
              $estado = htmlspecialchars($data[6]);

              echo '<tr>';
              echo '<td>' . $rut . '</td>';
              echo '<td>' . $nombre . '</td>';
              echo '<td>' . $direccion . '</td>';
              echo '<td>' . $fechNac . '</td>';
              echo '<td>' . $num . '</td>';
              echo '<td>' . $estado . '</td>';
              echo '<td>
                <center>
                    <span class="botones"><button type="button" class="btn btn-outline-dark" title="Editar"><i class="bi bi-pencil-square"></i></button></span>
                    <span class="botones"><a type="button" onclick="return alertaEliminar()" class="btn btn-outline-danger" title="Eliminar"><i class="bi bi-trash"></i></a></span>
                </center>

                            </td>';
              echo '</tr>';
            }
          }

          fclose($file);
        } else {
          echo '<tr><td colspan="5">No se encontró el archivo de estudiantes.</td></tr>';
        }
        ?>

      </tbody>
    </table>
  </section>
</main><!-- End #main -->

<?php include("footer.php"); ?>