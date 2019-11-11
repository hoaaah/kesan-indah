<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefDivisi */

$this->title = $model->unit_id;
$this->params['breadcrumbs'][] = ['label' => 'Ref Divisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-divisi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'unit_id',
            'divisi_id',
            'nama_divisi',
        ],
    ]) ?>

</div>
