<?php include("header.php"); ?>
<main id="main" class="main">


  <section class="section dashboard ">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Listado de estudiantes inscritos al curso</h2>
      <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Agregar estudiante
      </button>
    </div>
    <div class="alert alert-primary nopadding mt-2 mb-3" role="alert"><i class="bi bi-gear-fill"> Herramientas de programación</i></div>



    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #007bff; color: white;">
            <h5 class="modal-title" id="addStudentModalLabel"><i class="bi bi-person-plus"></i> Agregar Estudiante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Contenido del formulario para agregar estudiante -->
            <form>
              <div class="mb-3">
                <label for="studentName" class="form-label">Nombre del estudiante</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" class="form-control" id="studentName" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="studentEmail" class="form-label">Email del estudiante</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" class="form-control" id="studentEmail" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="studentAge" class="form-label">Edad del estudiante</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                  <input type="number" class="form-control" id="studentAge" required>
                </div>
              </div>


            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </div>
    </div>






    <table id="tabla" class="table table-bordered " cellspacing="0" width="100%">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Número</th> <!-- ENcabezados de las tablas-->
          <th>Nombre</th>
          <th>Correo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>d</td>
          <td>c</td>
          <td>d</td>
          <td>d</td>

          <td>
            <center>
              <abbr title="Editar"><button type="button" class="btn btn-outline-dark"><i class="bi bi-pencil-square"></i></button></abbr>
              <abbr title="Eliminar"><a type="button" onclick="return alertaEliminar()" class="btn btn-outline-danger"><i class="bi bi-trash"></i></a></abbr>
            </center>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</main><!-- End #main -->



<?php include("footer.php"); ?>