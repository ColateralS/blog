<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>
<?php require APPROOT . '/Vista/includes/cabeceraAdminPortada.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
</head>
<body>
    <div id="contenido"></div>
</body>
</html>
<script type="text/javascript">
    //$("#contenido").load('/blog/notice-form/');

    $(document).ready(function(){
        // Agregamos un evento clic a la opcion
        $('#usuarioLogueado').prop('value', 'H');
        //https://es.stackoverflow.com/questions/164602/como-capturar-variable-session-php-con-jquery

        $('#categoryForm').click(function(event){
            event.preventDefault();
            // Extraemos el nombre de la pagina que esta en el link
            var loadUrl = $(this).attr('href');
            $("#contenido").load(loadUrl);
        });
        $('#noticeForm').click(function(event){
            event.preventDefault();
            // Extraemos el nombre de la pagina que esta en el link
            var loadUrl = $(this).attr('href');
            $("#contenido").load(loadUrl);
        });
    });
</script>