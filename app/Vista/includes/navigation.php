<nav>  <!--class="top-nav"-->
    <ul>
        <li>
            <a href="<?php echo PAGE_URL; ?>/index">Home</a>
        </li>
        <li>
            <a href="<?php echo PAGE_URL; ?>/about">About</a>
        </li>
        <li>
            <a href="<?php echo PAGE_URL; ?>/projects">Projects</a>
        </li>
        <li>
            <a href="<?php echo PAGE_URL; ?>/posts">Blog</a>
        </li>
        <li>
            <a href="<?php echo PAGE_URL; ?>/contact">Contact</a>
        </li>
        <li class="btn-login">
            <?php if(isset($_SESSION['user_id'])) : ?>
                <a href="<?php echo PAGE_URL; ?>/blog/login-form">Log out</a>
            <?php else : ?>
                <a href="/blog/login-form/">Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>