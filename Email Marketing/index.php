<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form name="form" id="form" enctype="multipart/form-data" action="enviarEmail.php" method="post">
        <label>Arquivo excel</label>
        <br>
        <input type="file" id="arq" name="arq" accept=".xls,.xlsx">
        <br>

        html
        <br>
        <textarea id="html" name="html" style="width: 500px; height: 500px;"></textarea>

        <br>
        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>