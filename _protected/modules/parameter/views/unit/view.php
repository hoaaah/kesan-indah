<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefUnit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ref Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-unit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_unit_simda',
            'nama_unit',
            'alamat',
            'kepala_unit',
            'nip',
            'kecamatan_id',
            'kelurahan_id',
        ],
    ]) ?>

</div>
