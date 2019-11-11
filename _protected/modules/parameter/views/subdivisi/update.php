<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubDivisi */

$this->title = 'Update Ref Sub Divisi: ' . $model->unit_id;
$this->params['breadcrumbs'][] = ['label' => 'Ref Sub Divisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_id, 'url' => ['view', 'unit_id' => $model->unit_id, 'divisi_id' => $model->divisi_id, 'sub_divisi_id' => $model->sub_divisi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-sub-divisi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
