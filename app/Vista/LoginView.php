<?php

require APPROOT . '/Vista/includes/cabecera.php';


if (isset($data['display_login'])) {
?>

    <div class="row">
        <div class="col-12">

            <form action="/blog/login" method="POST">

                <div class="row form-group">
                    <div class="col-12">
                        <label for="nick_email">Nickname, email o usuario (*)</label>
                        <input type="text" name="nick_email" class="form-control" id="nick_email" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12">
                        <label for="pass">Contraseña (*)</label>
                        <input type="password" name="pass" class="form-control" />
                    </div>
                </div>

                <!--<div class="row form-group">
                    <div class="col-12">
                        <a href="/blog/remember-form">¿Has olvidado la contraseña?</a>
                    </div>
                </div>-->

                <div class="row form-group">
                    <div class="col-12">
                        <a href="/blog/register-form">¿No estas registrado?</a>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-6">
                        <button type="submit" name="action" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <div class="col-6">
                        <button type="button" name="back" class="btn btn-primary btn-block">Volver</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
<?php

} elseif (isset($data['display_recover_password'])) {
?>


    <div class="row">
        <div class="col-12">

            <form action="/blog/remember" method="POST">

                <div class="row form-group">
                    <div class="col-12">
                        <label for="email">Email (*)</label>
                        <input type="text" name="email" class="form-control" id="email" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-6">
                        <button type="submit" name="action" class="btn btn-primary btn-block">Cambiar contraseña</button>
                    </div>
                    <div class="col-6">
                        <button type="button" name="back" class="btn btn-primary btn-block">Volver</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

<?php
}
?>