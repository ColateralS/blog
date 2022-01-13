<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>


<div class="row">
    <div class="col-12">
    
    
        <?php
        if (isset($data['registry']) || isset($data['edit_profile'])) {
        ?>
        
        <div class='container mt-4'>
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
                            <option value="C"> Cedula </option>
                            <option value="R"> Ruc </option>
                            <option value="P"> Pasaporte </option>
                        </select>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="nuc">Número de Documento</label>
                        <input type="text" name="nuc" class="form-control" id="nuc" maxlength="15" value="<?php if (isset($data['info_user'])) {
                                                                                                                echo $data['info_user']['nuc'];
                                                                                                            } ?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <label for="pNombre">Primer Nombre (*)</label>
                        <input type="text" name="pNombre" class="form-control" id="pNombre" maxlength="50" value="<?php if (isset($data['info_user'])) {
                                                                                                                        echo $data['info_user']['pNombre'];
                                                                                                                    } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="sNombre">Segundo Nombre</label>
                        <input type="text" name="sNombre" class="form-control" id="sNombre" maxlength="50" value="<?php if (isset($data['info_user'])) {
                                                                                                                        echo $data['info_user']['sNombre'];
                                                                                                                    } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="pApellido">Primer Apellido (*)</label>
                        <input type="text" name="pApellido" class="form-control" id="pApellido" maxlength="50" value="<?php if (isset($data['info_user'])) {
                                                                                                                            echo $data['info_user']['pApellido'];
                                                                                                                        } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="sApellido">Segundo Apellido</label>
                        <input type="text" name="sApellido" class="form-control" id="sApellido" maxlength="50" value="<?php if (isset($data['info_user'])) {
                                                                                                                            echo $data['info_user']['sApellido'];
                                                                                                                        } ?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <label for="nickname">Alias (*)</label>
                        <input type="text" name="nickname" class="form-control" id="nickname" maxlength="20" value="<?php if (isset($data['info_user'])) {
                                                                                                                        echo $data['info_user']['nickname'];
                                                                                                                    } ?>" />
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="email">Email (*)</label>
                        <input type="text" name="email" <?php isset($data['edit_profile']) ? 'readonly' : '' ?> class="form-control" id="email" maxlength="40" value="<?php if (isset($data['info_user'])) {
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
                        <a class="btn btn-warning btn-block" href="/blog">Volver</a>
                    </div>
                </div>

            </form>
        </div>

        <?php
        } else if (isset($data['displayUsers'])) {
        ?>

            <div class="d-flex justify-content-center w-30">
                <?php if ($data['login']) { ?>
                    <div class="col-md-3 col-12">
                        <a id="AddNotice" class="btn btn-primary btn-block btn-icon" href="/blog/register-form">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Crear Usuario
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-12 mt-2">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Número de Documento</th>
                                <th scope="col">Primer Nombre</th>
                                <th scope="col">Segundo Nombre</th>
                                <th scope="col">Primer Apellido</th>
                                <th scope="col">Segundo Apellido</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($data['usuarios'])) {
                                // foreach ($data['categorias'] as $categoria => $c) {
                                foreach ($data['usuarios'] as $key => $value) {
                                    echo "<tr>";
                            ?>
                                    <td><a href=""><?php echo  $value['id']; ?></a></td>
                                    <td><?php echo $value['nuc']; ?></td>
                                    <td><?php echo  $value['primerNombre']; ?></td>
                                    <td><?php echo  $value['segundoNombre']; ?></td>
                                    <td><?php echo  $value['primerApellido']; ?></td>
                                    <td><?php echo  $value['segundoApellido']; ?></td>
                                    <td><a href="/blog/eliminar-usuario/<?php echo $value['id']; ?>"><i class="fas fa-trash icon delete-icon"></i></a></td>
                                    <td><a href="/blog/editar-usuario-form/<?php echo $value['id']; ?>"><i class="fas fa-edit icon edit-icon"></i></a></td>
                            <?php
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } elseif (isset($data['update'])) { ?>
            <div class="vertical-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h4>Editar Usuario</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <form id="formCategoria" action="/blog/editar-usuario/<?php echo $data['params'] ?>" method="POST" novalidate enctype="multipart/form-data">


                                <div class="row form-group">
                                    <div class="col-md-6 col-12">
                                        <label for="nuc">Número de Documento</label>
                                        <input type="text" name="nuc" class="form-control" id="nuc" maxlength="15" value="<?php if (isset($data['usuarios'][0])) {
                                                                                                                                echo $data['usuarios'][0]['nuc'];
                                                                                                                            } ?>" />
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="primerNombre">Primer Nombre (*)</label>
                                        <input type="text" name="primerNombre" class="form-control" id="pNombre" maxlength="50" value="<?php if (isset($data['usuarios'][0])) {
                                                                                                                                            echo $data['usuarios'][0]['primerNombre'];
                                                                                                                                        } ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="segundoNombre">Segundo Nombre</label>
                                        <input type="text" name="segundoNombre" class="form-control" id="sNombre" maxlength="50" value="<?php if (isset($data['usuarios'][0])) {
                                                                                                                                            echo $data['usuarios'][0]['segundoNombre'];
                                                                                                                                        } ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="primerApellido">Primer Apellido (*)</label>
                                        <input type="text" name="primerApellido" class="form-control" id="pApellido" maxlength="50" value="<?php if (isset($data['usuarios'][0])) {
                                                                                                                                                echo $data['usuarios'][0]['primerApellido'];
                                                                                                                                            } ?>" />
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="segundoApellido">Segundo Apellido</label>
                                        <input type="text" name="segundoApellido" class="form-control" id="sApellido" maxlength="50" value="<?php if (isset($data['usuarios'][0])) {
                                                                                                                                                echo $data['usuarios'][0]['segundoApellido'];
                                                                                                                                            } ?>" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-block" name="action" type="submit">Crear</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-block" name="back" type="button">Volver</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
