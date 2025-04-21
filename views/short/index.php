<?php
/** @var yii\web\View $this */
?>

<?php if(!empty($error)) { ?>
    <div>
        <?= $error ?>
    </div>
<?php } ?>

<script>
    let location_href_long = '<?= $href_long ?>';
</script>

<?php
$script = <<< JS
    $(document).ready(function() {
        if(location_href_long !== '') {        
            window.location.href = location_href_long;
        }
    });
JS;

$this->registerJs($script, $this::POS_END);
?>

