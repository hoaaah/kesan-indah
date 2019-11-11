<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefDivisiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-divisi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'unit_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'unit_id')])->label(false) ?>

    <?= $form->field($model, 'divisi_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'divisi_id')])->label(false) ?>

    <?= $form->field($model, 'nama_divisi')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nama_divisi')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
