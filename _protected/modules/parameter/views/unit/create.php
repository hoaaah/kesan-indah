<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefUnit */

$this->title = 'Create Ref Unit';
$this->params['breadcrumbs'][] = ['label' => 'Ref Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
