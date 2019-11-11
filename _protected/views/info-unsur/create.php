<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */

$this->title = 'Create Ref Sub Unsur';
$this->params['breadcrumbs'][] = ['label' => 'Ref Sub Unsurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-sub-unsur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
