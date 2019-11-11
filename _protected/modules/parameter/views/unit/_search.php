<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefUnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'id')])->label(false) ?>

    <?= $form->field($model, 'kd_unit_simda')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_unit_simda')])->label(false) ?>

    <?= $form->field($model, 'nama_unit')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nama_unit')])->label(false) ?>

    <?= $form->field($model, 'alamat')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'alamat')])->label(false) ?>

    <?= $form->field($model, 'kepala_unit')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kepala_unit')])->label(false) ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'kecamatan_id') ?>

    <?php // echo $form->field($model, 'kelurahan_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
