<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han seleccionado opciones
    if (isset($_POST['opciones'])) {
        // $_POST['opciones'] es un array con los valores seleccionados
        $opcionesSeleccionadas = $_POST['opciones'];

        // Convierte el array a una cadena separada por comas para el campo SET
        $opcionesComoString = implode(',', $opcionesSeleccionadas);

        // Ahora puedes usar $opcionesComoString para insertar en tu base de datos
        // ...
        var_dump($opcionesComoString);
    } else {
        // No se seleccionaron opciones
    }
}
?>
