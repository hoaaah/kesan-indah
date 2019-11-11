<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubDivisi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sub-divisi-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'sub_divisi_id')->textInput() ?>

    <?= $form->field($model, 'nama_sub_divisi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pengadaan')->checkbox() ?>

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
                $("#w3-tab2").html('<i class=\"fa fa-spinner fa-spin\"></i>');
                $.get("$pjaxUrl", function(data, status){
                    $("#w3-tab2").html(data);
                });
            }else
            {
                $.notify({message: result}, {type: 'danger', z_index: 10031})
            }
        }).fail(function(){
            $.notify({message: "Server Error, refresh and try again."}, {type: 'danger', z_index: 10031})
        });
    return false;
});

JS
);
?>