/**
* Template Name: NiceAdmin
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Updated: Apr 20 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function (e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }

  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function (e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }



})();
$(document).ready(function () {
  // Inicializar la primera tabla
  $('#tabla').DataTable({
    responsive: true,
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
      }
    }
  });

  // Inicializar tabla de notas
  $('#tablaNotas').DataTable({
    responsive: true,
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
      }
    },
    "createdRow": function (row, data, index) {
      if (data[6] == 'Reprobado') {
        $('td', row).css({
          'background-color': '#ffb6af',

          'color': 'black'

        });
      }

    }
  });
});



function eliminar() {
  var mensaje;
  var opcion = confirm("¿Desea eliminar el registro?");
  if (opcion == true) {
    return true;
  } else {
    return false;
  }
}

function eliminarNotas() {
  var mensaje;
  var opcion = confirm("¿Desea eliminar las notas del estudiante?");
  if (opcion == true) {
    return true;
  } else {
    return false;
  }
}

// Cargar el modal con los datos del estudiante al hacer clic en el botón
function openEditModal(idEstudiante, rut, nombre, nota1, nota2, nota3, idUsuario, idNota) {
  document.getElementById('rut').value = rut;
  document.getElementById('studentName').value = nombre;
  document.getElementById('nota1').value = nota1;
  document.getElementById('nota2').value = nota2;
  document.getElementById('nota3').value = nota3;
  document.getElementById('idEstudiante').value = idEstudiante;
  document.getElementById('idUsuario').value = idUsuario;
  document.getElementById('idNota').value = idNota;
}


//Alertas (mensajes)
setTimeout(function () {
  const alert = document.querySelector('.custom-alert');
  if (alert) {
    alert.classList.remove('show');
    alert.classList.add('fade');
    setTimeout(() => alert.remove(), 500);
  }
}, 3000); // Tiempo en milisegundos antes de cerrar la alerta


//Validaciones para inputs
// Eliminar puntos y guiones del RUT
const rutInput = document.getElementById('rut');
rutInput.addEventListener('input', function () {
  this.value = this.value.replace(/[.-]/g, '');
});

// Validar el número de apoderado
const numeroApoderadoInput = document.getElementById('num_apoderado');
numeroApoderadoInput.addEventListener('input', function () {
  const valor = this.value;
  // Solo permite 9 dígitos y que el primero sea 9
  if (!/^9\d{0,8}$/.test(valor)) {
    this.value = valor.slice(0, -1); // Elimina el último carácter
  }
});

// Validar la fecha de nacimiento
const fechaInput = document.getElementById('fecha_nacimiento');
fechaInput.min = '2022-01-01'; // Establecer la fecha mínima
fechaInput.max = '2023-12-31'; // Establecer la fecha máxima

// Validación al enviar el formulario
document.getElementById('addStudentForm').addEventListener('submit', function (event) {
  let isValid = true;

  // Validar el RUT
  if (!/^\d{8}[0-9kK]$/.test(rutInput.value)) {
    isValid = false;
    alert('El RUT debe tener el formato correcto: 211410884 (sin puntos ni guiones).');
  }

  // Validar el número de apoderado
  if (!/^9\d{8}$/.test(numeroApoderadoInput.value)) {
    isValid = false;
    alert('El número de apoderado debe tener 9 dígitos y comenzar con 9.');
  }

  // Cancelar el envío si hay errores
  if (!isValid) {
    event.preventDefault(); // Evitar el envío del formulario
  }
});

// Script para cargar los datos del estudiante en el modal de edición
document.querySelectorAll('.edit-button').forEach(button => {
  button.addEventListener('click', function () {
    document.getElementById('edit_student_id').value = this.dataset.id;
    document.getElementById('edit_rut').value = this.dataset.rut;
    document.getElementById('edit_nombre').value = this.dataset.nombre;
    document.getElementById('edit_fecha_nacimiento').value = this.dataset.fechaNacimiento;
    document.getElementById('edit_direccion').value = this.dataset.direccion;
    document.getElementById('edit_num_apoderado').value = this.dataset.numApoderado;

  });
});


//para gráfico

// Para asegurarse de que la tabla sea responsive y tenga capacidad de DataTables
$(document).ready(function () {
  $('#tablaNotas').DataTable({
    responsive: true,
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" // Traducir a español
    }
  });
});