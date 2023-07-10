<!-- MUY IMPORTANTE PARA PODER ENLAZAR LAS URL DE LAS LISTAS DE LA NAVEGACION-->
<?php
    $url_base ="http://localhost/REPASO_BACK_END/appRepaso/";
?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo $url_base?>index.php" aria-current="page">Sistema <span class="visually-hidden">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base ?>secciones/empleados/index.php">Empleado</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base ?>secciones/puesto">Puesto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base ?>secciones/usuario">Usuario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">CERRAR SESION</a>
            </li>
        </ul>
    </nav>
  </header>
  <main class="container">

</br>