<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefUnit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-unit-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'kd_unit_simda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kepala_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kecamatan_id')->dropDownList(
        ArrayHelper::map(\app\models\RefKecamatan::find()->all(),'Kd_Kecamatan','Nm_Kecamatan'),
        [
            'prompt'=>'Pilih Kecamatan ...',
            'onchange'=>'
                $.post("'.Yii::$app->urlManager->createUrl('/parameter/unit/kelurahan?id=').'"+$(this).val(),function(data)
                { $("select#refunit-kelurahan_id" ).html(data);
            });'
        ]
    ); ?>

    <?= $form->field($model, 'kelurahan_id')->dropDownList(
        ArrayHelper::map(\app\models\RefDesa::find()->all(),'Kd_Desa','Nm_Desa'),
        [
            'prompt'=>'Pilih Desa/Kelurahan',
        ]
    ) ?>     

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
                $.pjax.reload({container:'#ref-unit-pjax'});
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