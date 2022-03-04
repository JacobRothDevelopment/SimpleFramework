<p>"this is from a component"</p>
<p>
    <?php
    $link = "/page1";
    if ($_SERVER['REQUEST_URI'] === $link) {
        $link = "/";
    }
    ?>
    <a href=<?php echo $link ?>>Go to <?php echo $link ?></a>
</p>