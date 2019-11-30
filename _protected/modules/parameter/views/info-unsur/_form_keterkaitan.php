<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */
/* @var $form yii\widgets\ActiveForm */

if(!$model->isNewRecord){
    $model->kd_gabungan_lwn = "{$model->kd_unsur_lwn}.{$model->kd_sub_unsur_lwn}";
}
?>

<div class="ref-sub-unsur-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'kd_gabungan_lwn')->widget(Select2::classname(), [
        'data' => $subUnsurList,
        'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Sub Unsur ...', 
        // 'onchange'=> 'this.form.submit()'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false) ?>

    <?= $form->field($model, 'level_lwn')->widget(Select2::classname(), [
        'data' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
        'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Level ...', 
        // 'onchange'=> 'this.form.submit()'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false) ?>

    <?= $form->field($model, 'uraian')->textInput() ?>

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