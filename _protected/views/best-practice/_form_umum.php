<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bizley\quill\Quill;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sub-unsur-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'uraian')->widget(Quill::class, [
        'theme' => 'snow',
        'toolbarOptions' => 'FULL',
        'options' => [
            'style' => 'min-height:500px;'
            // 'min-height' => '500px'
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-plus"></i>Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs(<<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#ajaxCrudModal").modal('hide'); //hide modal after submit
                // $.pjax.reload({container:'#ref-sub-unsur-pjax'});
            }else
            {
                $.notify({message: result}, {type: 'danger', z_index: 10031})
            }
        }).fail(function(){
            // $.notify({message: "Server Error, refresh and try again."}, {type: 'danger', z_index: 10031})
        });
    return false;
});

JS
);
?>