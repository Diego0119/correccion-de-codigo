# Notas
Aplicación para gestión de notas, usando PHP, sin base de datos

Exp1
Bloque de código con las importaciones de css necesarios:
-bootstrap
-bootstrap icons
-datatables
-Google Fonts
-Archivo css

Exp2
Apartado de header, para la navegación vertical
El header tiene fixed-top para mantenerse fijo al hacer scroll, y usa d-flex con align-items-center para alinear elementos de forma horizontal y centrarlos verticalmente. Dentro, el contenedor del logo usa d-flex para organizar el logo y el texto "EduScore", y justify-content-between para distribuir elementos en los extremos. La clase d-none d-lg-block oculta el texto del logo en pantallas pequeñas y lo muestra en pantallas grandes. Finalmente, la sección del perfil usa nav-profile, con una imagen de perfil redonda y un nombre oculto en pantallas pequeñas (d-none d-md-block).

Exp3
Apartado para sidebar
La clase sidebar define el diseño general del elemento, mientras que sidebar-nav se aplica a la lista no ordenada para dar formato a la navegación. Se centra el contenido del encabezado con text-center, y se usan clases como fw-bold para resaltar el título "Herramientas de programación". Las etiquetas <a> con las clases nav-link y collapsed crean enlaces, cada uno acompañado de iconos de Bootstrap Icons.

Exp4
El <footer> con el ID footer y la clase footer marca el final de la sección de contenido, donde se pueden incluir elementos como información de contacto, después se incluyen varios scripts JavaScript: primero, se carga jQuery, luego se carga bootstrap.bundle.min.js, que incluye el JavaScript de Bootstrap junto con sus dependencias, además se cargan las necesarias para los DataTables y por último el archivo js.

Exp5
Apartado de mensajes, muestra el mensaje dependiendo de la acción de editar/eliminar 
El mensaje se manda desde los archivos de editarNotas.php o eliminarNotas.php, dependiendo del mensaje, se hace uso de las sessiones para mostrarla.

Exp6
Se hace uso de clases para mostrar tanto el título como el subtítulo, el segundo mediante una alerta, acompañada de un icono.

Exp7
Tabla que hace uso de datatable para filtrado, paginación y responsividad de la misma, 
en el archivo .js se encuentra la inicialización con las caracterísiticas de la misma
-El botón editar hace uso de una función para cargar los datos registrados previamente en el modal
-El botón eliminar manda el id para identificar el registro

Exp8
Modal que permite actualizar las notas o realizar cambios en estas, manda mediante POST los datos y son recibidos en "editarNotas.php"