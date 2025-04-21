<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Геномед';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">

        <?php $form = ActiveForm::begin(['id' => 'href-form']); ?>

            <?= $form->field($model, 'href_long')->textInput(['id' => 'href_long',  'value' => 'https://ixbt.games/news/2025/04/19/servery-dune-awakening-ogranicat-40-igrokami.html']) ?>

            <p>
                <div id="errors"></div>
            </p>

            <div class="form-group">
                <?= Html::submitButton('Получить короткую ссылку и QR', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div id="block_result" class="jumbotron text-center bg-transparent mt-5 mb-5" style="display: none;">

        <p>
            <img id="qr-image" src="<?= $model->qr_image ?>" alt="<?= $model->qr_image ?>">
        </p>

        <p>
            Короткая ссылка:
        </p>

        <p>
            <span id="href-short-txt"></span>
        </p>

        <p>
            Перейти по ссылке:
        </p>

        <p>
            <a id="href-short-href" href="<?= $model->href_short ?>" target="_blank"><span id="href-short-href-txt"></span></a>
        </p>

    </div>

</div>

<?php
$script = <<< JS
    $(document).ready(function() {

        $('#href-form').submit(function(event) {
            event.preventDefault();
            
            $('#errors').html('');
            $('.help-block').html('');
            
  			var link = $('#href_long').val();
            const regex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
            const isValidComplexUrl = (url) => regex.test(url);

            if(!isValidComplexUrl(link)) {
                return false;
            }
            
            var data = $("#href-form :input").serializeArray();
    
            $.ajax({ 
                url: '/web/get-href-short',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(data){
                    if(data.result) {                
                        
                        $('#qr-image').attr('src', data.data.qr_image);
                        $('#qr-image').attr('alt', data.data.qr_image);
                        
                        $('#href-short-txt').html(data.data.href_short);
                        
                        $('#href-short-href').attr('href', data.data.href_short);
                        
                        $('#href-short-href-txt').html(data.data.href_short);

                        $('#block_result').show();
                    }
                    else {
                        $('#errors').html(data.errors);
                    }
                },
                error: function(){
                    console.log('failure');
                }
            });
            
        });

    });

JS;

$this->registerJs($script, $this::POS_END);
?>