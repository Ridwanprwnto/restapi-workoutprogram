<script type="text/javascript">
    $(document).ready(function(){
        <?php
            if (isset($alert)) {
        ?>
            alert(<?= $alert; ?>);
        <?php
            }
        ?>
    });
</script>