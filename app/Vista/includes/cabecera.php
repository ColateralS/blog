<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only - Se incluye enlace con la biblioteca de bootstrap -->
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo PAGE_URL ?>/public/css/Estilos.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex w-100 justify-content-between">
        <a class="navbar-brand" href="/blog">El Anunciante</a>
        <div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="btn-login" href="/blog/login-form/">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
</body>

</html>

<?php
include_once APPROOT . '/Vista/mostrarInformacionMensaje.php';
?>