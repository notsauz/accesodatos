<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio</title>
    <link rel="stylesheet" href="/public/css/style.css" />
    <script src="/public/js/main.js"></script>
</head>
<body>
    <h1>FORMULARIO</h1>
    <form name="form" action="/daw_servidor/forms/procesarDatos">
        <div>
            <label>Nombre: </label>
            <input type="text" name="nombre" value="" />
        </div>
        <div>
            <label>Curso: </label>
            <input type="radio" id="primero" name="curso" value="primero" /><label for="primero">Primero</label>
            <input type="radio" id="segundo" name="curso" value="segundo" /><label for="segundo">Segundo</label>
        </div>
        <div>
            <input type="submit" name="Enviar" />
        </div>
    </form>
</body>
</html>
