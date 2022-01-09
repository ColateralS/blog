<?php
require APPROOT . '/Vista/includes/cabecera.php';
?>
<div class="news-container">
    <?php

    foreach ($data['portada'] as $portada => $p) {
    ?>
        <a href="/blog/detailNotice-form/<?php echo $p['id']; ?>" class="list-group-item list-group-item-action">
            <div class="news-image">
                <img src="data:image/jpg;base64,<?php echo base64_encode($p['imagen']); ?>" alt="" />
            </div>

            <p class="news-category mt-3 mb-3"><?php echo $p['catNoticia'] ?></p>
            <h5 class="m-2"><?php echo $p['titulo'] ?></h5>
            <p class="m-2"><?php echo $p['detalle'] ?></p>
            <p class="news-date"><?php echo $p['fechaPublicacion'] ?></p>

        <?php
    }
        ?>
        </a>
</div>