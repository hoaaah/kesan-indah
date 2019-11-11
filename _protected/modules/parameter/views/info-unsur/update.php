<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */

$this->title = 'Update Ref Sub Unsur: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ref Sub Unsurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-sub-unsur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
