<?php require APPROOT . '/Vista/includes/topAdminPortada.php'; ?>
<? //php require APPROOT . '/Vista/includes/cabeceraAdminPortada.php'; 
?>
<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-12">

                <?php if (isset($data['detail'])) { ?>

                    <ul class="list-group">
                        <?php
                        foreach ($data['desgloseNoticia'] as $desglose => $d) {
                        ?>
                            <li class="list-group-item"><?php echo $d['desglose'] ?></li>
                        <?php
                        }
                        ?>
                    </ul>

                <?php } elseif (isset($data['create'])) { ?>
                    <div class="row">
                        <div class="col-12">
                            <?php if (isset($data['params'])) { ?>
                                <h4>Creacion de desglose de noticia [ <?php echo $data['params'] ?> ]</h4>
                            <?php } else { ?>
                                <h4>Creacion de desglose de noticia</h4>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <form id="formDesgloseNoticia" action="/blog/detailCreate-notice/<?php echo $data['params'] ?>" method="POST" novalidate enctype="multipart/form-data">

                                <div class="row form-group">
                                    <div class="col-12">
                                        <label for="desglose">Desglose</label>
                                        <textarea name="desglose" required class="form-control" id="desglose" cols="20" rows="4"></textarea>
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