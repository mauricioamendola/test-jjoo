<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<form action="insertSport.php" method="post" enctype="multipart/form-data">
    <label for="sportName" class="form-label">Nombre del deporte:</label>
    <input type="text" name="sportName" id="sportName">
    <br><br>
    <label for="sportDescription" class="form-label">Descripción del deporte:</label>
    <textarea name="sportDescription" id="sportDescription" cols="20" rows="5"></textarea>
    <br><br>
    <label for="sportPic" class="form-label">Seleccionar icono del deporte:</label>
    <input type="file" name="sportPic" id="sport-picture">
    <br><br>
    <input type="submit" value="Añadir deporte" name="submit">
</form>

</body>
</html>
