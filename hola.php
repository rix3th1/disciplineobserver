<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radios Agrupados (Múltiple Selección)</title>
</head>
<body>

<form action="procesar_formulario.php" method="post">
    <label>
        <input type="checkbox" name="opciones[]" value="opcion1"> Opción 1
    </label>
    <br>
    <label>
        <input type="checkbox" name="opciones[]" value="opcion2"> Opción 2
    </label>
    <br>
    <label>
        <input type="checkbox" name="opciones[]" value="opcion3"> Opción 3
    </label>
    <br>

    <input type="submit" value="Enviar">
</form>

</body>
</html>
