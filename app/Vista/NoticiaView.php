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
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Crear noticia
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
                                        <th scope="col">Titulo</th>
                                        <th scope="col">Detalle</th>
                                        <th scope="col">Fecha Publicación</th>
                                        <th scope="col">Crear Desglose</th>
                                        <th scope="col">Eliminar</th>
                                        <th scope="col">Actualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($data['noticias'])) {
                                        foreach ($data['noticias'] as $key => $value) {
                                            echo "<tr>";
                                    ?>
                                            <td><a href=""><?php echo  $value['idNoticia']; ?></a></td>
                                            <td><?php echo  $value['titulo']; ?></td>
                                            <td><?php echo  $value['detalle']; ?></td>
                                            <td><?php echo  $value['fechaPublicacion']; ?></td>
                                            <td><a href="/blog/detailCreate-notice-form/<?php echo $value['idNoticia']; ?>"><i class="fas fa-plus-square icon create-icon"></i></a></td>
                                            <td><a href="/blog/eliminar-noticia/<?php echo $value['idNoticia']; ?>"><i class="fas fa-trash icon delete-icon"></i></a></td>
                                            <td><a href="/blog/editar-noticia-form/<?php echo $value['idNoticia']; ?>"><i class="fas fa-edit icon edit-icon"></i></a></td>
                                    <?php
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php include_once "pagination-controls.php"; ?>
                        </div>
                    </div>

                <?php } elseif (isset($data['create'])) { ?>
                    <div class="vertical-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Crear Noticia</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <form id="formNoticia" action="/blog/crear-noticia" method="POST" novalidate enctype="multipart/form-data">

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="categoria">Categoria</label>
                                                <select name="cbxCategoria" id="cbxCategoria">
                                                    <option value="0"> -- Seleccionar -- </option>
                                                    <option value="1"> Politica </option>
                                                    <option value="2"> Economia </option>
                                                    <option value="3"> En exclusiva </option>
                                                    <option value="4"> Informes </option>
                                                    <option value="5"> Seguridad </option>
                                                    <option value="6"> Comunidad </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="titulo">Titulo</label>
                                                <textarea name="titulo" required class="form-control" id="titulo" cols="20" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="detalle">Detalle</label>
                                                <textarea name="detalle" required class="form-control" id="detalle" cols="20" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="embebido">Archivo</label>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" id="imagen" name="imagen" multiple>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="fechaPublicacion">Fecha publicacion</label>
                                                <input type="text" class="form-control" name="fechaPublicacion" maxlength="10" required id="fechaPublicacion" placeholder="dd/mm/yyyy" />
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="estado">Estado</label>
                                                <select name="cbxEstado" id="cbxEstado">
                                                    <option value="0"> -- Seleccionar -- </option>
                                                    <option value="PB"> Publicar </option>
                                                    <option value="NP"> No Publicar </option>
                                                </select>
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
                                    <h4>Editar Noticia</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <form id="formNoticia" action="/blog/editar-noticia/<?php echo $data['params'] ?>" method="POST" novalidate enctype="multipart/form-data">
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" name="titulo" class="form-control" id="titulo" value="<?php if (isset($data['noticias'][0])) {
                                                                                                                                echo $data['noticias'][0]['titulo'];
                                                                                                                            } ?>" />
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="descripcion">Descripción</label>
                                                <input type="text" name="detalle" class="form-control" id="detalle" value="<?php if (isset($data['noticias'][0])) {
                                                                                                                                echo $data['noticias'][0]['detalle'];
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

    </div>
</div>