<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsurSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sub-unsur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'id')])->label(false) ?>

    <?= $form->field($model, 'kd_unsur')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_unsur')])->label(false) ?>

    <?= $form->field($model, 'kd_sub_unsur')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_sub_unsur')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'name')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
