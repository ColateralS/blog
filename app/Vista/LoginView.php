<?php

// require APPROOT . '/Vista/includes/cabecera.php';

if (isset($data['display_login'])) {
?>
    <div class="login-container">

        <div class="login-form">
            <h3 class="m-5 d-flex justify-content-center">Inicio de Sesión</h3>
            <form action="/blog/login" method="POST">
                <div class="row form-group">
                    <div class="col-12">
                        <label for="nick_email">Usuario</label>
                        <input type="text" name="nick_email" class="form-control" id="nick_email" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12">
                        <label for="pass">Contraseña</label>
                        <input type="password" name="pass" class="form-control" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12">
                        <a href="/blog/register-form">¿No estas registrado?</a>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-6">
                        <button type="submit" name="action" class="btn btn-primary btn-block">Iniciar Sesión</button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-warning btn-block" href="/blog">Volver</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

<?php
}
include_once APPROOT . '/Vista/mostrarInformacionMensaje.php';
?>