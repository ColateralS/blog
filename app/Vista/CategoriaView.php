<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>
<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-12">
                <?php if (isset($data['display'])) { ?>

                    <div class="d-flex justify-content-center w-30">
                        <?php if ($data['login']) { ?>
                            <div class="col-md-3 col-12">
                                <a id="AddNotice" class="btn btn-primary btn-block btn-icon" href="/blog/crear-noticia-form/">
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
                                            <td><a href="/blog/<?php echo $value['id']; ?>"><i class="fas fa-trash icon delete-icon"></i></a></td>
                                            <td><a href="/blog/<?php echo $value['id']; ?>"><i class="fas fa-edit icon edit-icon"></i></a></td>
                                    <?php
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>