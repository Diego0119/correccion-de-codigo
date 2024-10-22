<?php
include("../header.php");
include("../functions/functions.php");

// Comprobamos que el usuario esté logueado y sea estudiante
if ($tipoUsuario != "estudiante") {
    header("Location: /Notas/index.php"); // Redireccionar si no es un estudiante
    exit();
}

// Obtener las notas del estudiante logueado
$notasEstudiante = obtenerNotasEstudiante($idUsuario);
?>

<main id="main" class="main">
<h2 class="mb-0">Mis Notas</h2>
<div class="alert alert-primary nopadding mt-2 mb-3" role="alert"><i class="bi bi-gear-fill">Resumen de notas</i></div>
    <section class="section dashboard">
        <div class="d-flex justify-content-between align-items-center">
           
        </div>

        <!-- Verificar si el estudiante tiene notas registradas -->
        <?php if (!empty($notasEstudiante)): ?>
            <div class="row">
                <!-- Tabla de Notas a la izquierda -->
                <div class="col-md-6">
                    <table id="tablaNotas" class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Profesor</th>
                                <th>Nota 1</th>
                                <th>Nota 2</th>
                                <th>Nota 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notasEstudiante as $nota): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($nota['asignatura']); ?></td>
                                    <td><?php echo htmlspecialchars($nota['profesor']); ?></td>
                                    <td><?php echo htmlspecialchars($nota['nota1'] === 'Pendiente' ? 0 : $nota['nota1']); ?></td>
                                    <td><?php echo htmlspecialchars($nota['nota2'] === 'Pendiente' ? 0 : $nota['nota2']); ?></td>
                                    <td><?php echo htmlspecialchars($nota['nota3'] === 'Pendiente' ? 0 : $nota['nota3']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Gráfico a la derecha -->
                <div class="col-md-6">
                    <canvas id="graficoNotas" class="mt-2"></canvas>
                </div>
            </div>


            <script>
                const ctx = document.getElementById('graficoNotas').getContext('2d');

                // Colores predefinidos para cada asignatura
                const backgroundColors = [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ];

                const borderColors = [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ];

                const datasets = [];

                <?php foreach ($notasEstudiante as $index => $nota): ?>
                    datasets.push({
                        label: '<?php echo htmlspecialchars($nota['asignatura']); ?>',
                        data: [
                            <?php
                            echo ($nota['nota1'] === 'Pendiente' ? 0 : $nota['nota1']) . ',';
                            echo ($nota['nota2'] === 'Pendiente' ? 0 : $nota['nota2']) . ',';
                            echo ($nota['nota3'] === 'Pendiente' ? 0 : $nota['nota3']);
                            ?>
                        ],
                        backgroundColor: backgroundColors[<?php echo $index; ?> % backgroundColors.length],
                        borderColor: borderColors[<?php echo $index; ?> % borderColors.length],
                        borderWidth: 1
                    });
                <?php endforeach; ?>

                const notasData = {
                    labels: ['Nota 1', 'Nota 2', 'Nota 3'],
                    datasets: datasets
                };

                const graficoNotas = new Chart(ctx, {
                    type: 'bar',
                    data: notasData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 7 // Establecer el máximo de las notas en 7
                            }
                        }
                    }
                });

                // Para asegurarse de que la tabla sea responsive y tenga capacidad de DataTables
                $(document).ready(function() {
                    $('#tablaNotas').DataTable({
                        responsive: true,
                        language: {
                            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" // Traducir a español
                        }
                    });
                });
            </script>

        <?php else: ?>
            <p class="text-center">No tienes notas registradas.</p>
        <?php endif; ?>
    </section>
</main>



<?php
include("../footer.php");
?>