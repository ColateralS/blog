<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>
<?//php require APPROOT . '/Vista/includes/cabeceraAdminPortada.php'; ?>
<div class="row">
    <div class="col-12">

    <div class="row">
        <div class="col-12">

            <?php if (isset($data['display'])) { ?>

                <div class="row">
                    <?php if ($data['login']) { ?>
                        <div class="col-md-3 col-12">
                            <a id="AddNotice" class="btn btn-primary btn-block btn-icon"
                                href="/blog/crear-noticia-form/">
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
                                    <th scope="col">Id Noticia</th>
                                    <th scope="col">Titulo</th>
                                    <!--<th scope="col">Embebido</th>-->
                                    <th scope="col">Fecha Publicacion</th>
                                    <th scope="col">Desglose Noticia</th>
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
                                                <!--<td>
                                                    <img src="data:image/jpg;base64,<?php //echo base64_encode($value['embebido']); ?>" alt="" />
                                                </td>-->
                                                <td><?php echo  $value['fechaPublicacion']; ?></td>
                                                <td><a href="/blog/detailCreate-notice-form/<?php echo $value['idNoticia'] ; ?>">Crear Desglose</a></td>
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
                        <?php include_once "pagination-controls.php";?>
                    </div>
                </div>

            <?php } elseif (isset($data['create'])) { ?>
                <div class="row">
                    <div class="col-12">
                        <h4>Creacion de una noticia</h4>
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
                                            <option value="1">  Politica  </option>
                                            <option value="2">  Economia  </option>
                                            <option value="3">  En exclusiva  </option>
                                            <option value="4">  Informes  </option>
                                            <option value="5">  Seguridad  </option>
                                            <option value="6">  Comunidad  </option>
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
                                            <option value="PB">  Publicar  </option>
                                            <option value="NP">  No Publicar  </option>
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
            <?php } ?> 

        </div>
    </div>

    </div>
</div>