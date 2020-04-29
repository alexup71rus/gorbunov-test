    <?php
    if (isset($requires['js']) && count($requires['js'])) {
        \Router::addJs($requires['js']);
    }
    ?>
</body>
</html>
