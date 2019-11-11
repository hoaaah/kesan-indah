<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefDivisi */

$this->title = 'Create Ref Divisi';
$this->params['breadcrumbs'][] = ['label' => 'Ref Divisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-divisi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
