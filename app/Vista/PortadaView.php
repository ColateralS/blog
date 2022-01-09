<?php
   require APPROOT . '/Vista/includes/cabecera.php';
?>
<div class="list-group">
    <?php
        
        foreach ($data['portada'] as $portada => $p) {
    ?>
            <a href="/blog/detailNotice-form/<?php echo $p['id']; ?>" 
                class="list-group-item list-group-item-action flex-column align-items-start">
                <img src="data:image/jpg;base64,<?php echo base64_encode($p['imagen']); ?>" alt="" width="20%" height="20%" />
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo $p['titulo']?></h5>
                    <small><?php echo $p['catNoticia']?></small>
                </div>
                <p class="mb-1"><?php echo $p['detalle']?></p>
                <small><?php echo $p['fechaPublicacion']?></small>
                <div class="dropdown-divider"></div>
    <?php
        }
    ?>    
            </a>
</div>