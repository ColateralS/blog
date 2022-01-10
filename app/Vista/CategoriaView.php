<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>
<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-12">
                <?php if (isset($data['display'])) { ?>

                    <div class="d-flex justify-content-center w-30">
                        <?php if ($data['login']) { ?>
                            <div class="col-md-3 col-12">
                                <a id="AddNotice" class="btn btn-primary btn-block btn-icon" href="/blog/crear-categoria-form/">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Crear categoria
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
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Eliminar</th>
                                        <th scope="col">Actualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($data['categorias'])) {
                                        // foreach ($data['categorias'] as $categoria => $c) {
                                        foreach ($data['categorias'] as $key => $value) {
                                            echo "<tr>";
                                    ?>
                                            <td><a href=""><?php echo  $value['id']; ?></a></td>
                                            <td><?php echo $value['nombre']; ?></td>
                                            <td><?php echo  $value['descripcion']; ?></td>
                                            <td><a href="/blog/eliminar-categoria/<?php echo $value['id']; ?>"><i class="fas fa-trash icon delete-icon"></i></a></td>
                                            <!-- <td><a href="/blog/editar-categoria-form"><i class="fas fa-edit icon edit-icon"></i></a></td> -->
                                            <td><a href="/blog/editar-categoria-form/<?php echo $value['id']; ?>"><i class="fas fa-edit icon edit-icon"></i></a></td>
                                    <?php
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } elseif (isset($data['create'])) { ?>
                    <div class="vertical-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Crear Categoria</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <form id="formCategoria" action="/blog/crear-categoria" method="POST" novalidate enctype="multipart/form-data">

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="titulo">Nombre</label>
                                                <textarea name="nombre" required class="form-control" id="nombre" cols="20" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="titulo">Descripcion</label>
                                                <textarea name="descripcion" required class="form-control" id="descripcion" cols="20" rows="4"></textarea>
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
                <?php } elseif (isset($data['update'])) { ?>
                    <div class="vertical-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Editar Categoria</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <form id="formCategoria" action="/blog/editar-categoria/<?php echo $data['params'] ?>" method="POST" novalidate enctype="multipart/form-data">
                                        <?php 
                                            print_r($data['categorias']);
                                            print_r($data['params']);
                                         ?>
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" id="nombre" maxlength="15" value="<?php if (isset($data['categorias'])) {
                                                                                                                                            echo $data['categorias']['nombre'];
                                                                                                                                        } ?>" />
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="descripcion">Descripcion</label>
                                                <textarea name="descripcion" required class="form-control" id="descripcion" cols="20" rows="4"></textarea>
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
    </div>
</div>