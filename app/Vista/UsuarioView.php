<?php
   require APPROOT . '/Vista/includes/cabecera.php';
?>

<div class='container'>
<div class="row">
    <div class="col-12">

        <?php
        if (isset($data['registry']) || isset($data['edit_profile'])) {
        ?>

            <form id="formUsuario" action="/blog/<?php echo isset($data['registry']) ? 'register' : 'editar-perfil'; ?>" method="POST">

                <?php
                if (isset($data['edit_profile'])) {
                ?>
                    <input type="hidden" name="id_user" value="<?php echo $data['info_user']['id']; ?>" />
                    <input type="hidden" name="rol" value="<?php echo $data['info_user']['rol']; ?>" />
                <?php
                }
                ?>

                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <label for="tipoNuc">Tipo de Documento (*)</label>
                        <select name="cbxtipoNuc" id="cbx_estado">
                            <option value="0"> -- Seleccionar -- </option>
                            <option value="C">  Cedula  </option>
                            <option value="R">  Ruc  </option>
                            <option value="P">  Pasaporte  </option>
                        </select>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="nuc">Número de Documento</label>
                        <input type="text" name="nuc" class="form-control" id="nuc" maxlength="15" 
                            value="<?php if (isset($data['info_user'])) {
                                            echo $data['info_user']['nuc'];
                                        } ?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <label for="pNombre">Primer Nombre (*)</label>
                        <input type="text" name="pNombre" class="form-control" id="pNombre" maxlength="50" 
                            value="<?php if (isset($data['info_user'])) {
                                            echo $data['info_user']['pNombre'];
                                        } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="sNombre">Segundo Nombre</label>
                        <input type="text" name="sNombre" class="form-control" id="sNombre" maxlength="50" 
                            value="<?php if (isset($data['info_user'])) {
                                            echo $data['info_user']['sNombre'];
                                        } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="pApellido">Primer Apellido (*)</label>
                        <input type="text" name="pApellido" class="form-control" id="pApellido" maxlength="50" 
                            value="<?php if (isset($data['info_user'])) {
                                            echo $data['info_user']['pApellido'];
                                        } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="sApellido">Segundo Apellido</label>
                        <input type="text" name="sApellido" class="form-control" id="sApellido" maxlength="50" 
                            value="<?php if (isset($data['info_user'])) {
                                            echo $data['info_user']['sApellido'];
                                        } ?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <label for="nickname">Alias (*)</label>
                        <input type="text" name="nickname" class="form-control" id="nickname" maxlength="20" 
                                value="<?php if (isset($data['info_user'])) {
                                                echo $data['info_user']['nickname'];
                                            } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="email">Email (*)</label>
                        <input type="text" name="email" 
                            <?php isset($data['edit_profile']) ? 'readonly' : '' ?> 
                            class="form-control" id="email" maxlength="40" value="<?php if (isset($data['info_user'])) {
                                                                                        echo $data['info_user']['email'];
                                                                                    } ?>" />
                        <div class="valid-feedback">
                            ¡Es correcto!
                        </div>
                        <div class="invalid-feedback">
                            El email no tiene el formato correcto
                        </div>
                    </div>
                </div>

                <?php
                if (isset($data['registry'])) {
                ?>
                    <div class="row form-group">
                        <div class="col-md-6 col-12">
                            <label for="pass">Contraseña (*)</label>
                            <input type="password" id="password" name="pass" class="form-control" id="" maxlength="10" />
                            <div class="valid-feedback">
                                ¡Es correcto!
                            </div>
                            <div class="invalid-feedback">
                                La contraseña debe tener minusculas, mayusculas y numeros. La longitud entre 8 y 10 caracteres
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="confirm-pass">Confirmar contraseña (*)</label>
                            <input type="password" name="confirm-pass" class="form-control" id="confirm-pass" maxlength="10" />
                        </div>
                    </div>
                <?php
                }

                ?>

                <div class="row form-group">
                    <div class="col-6">
                        <button type="submit" name="action" class="btn btn-primary btn-block">
                                <?php echo isset($data['registry']) ? 'Registro' : 'Editar'; ?>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" name="back" class="btn btn-primary btn-block">Volver</button>
                    </div>
                </div>

            </form>

             <?php } ?>
    </div>
    </div>
</div>