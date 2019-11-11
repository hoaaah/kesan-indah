<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefOpini */
?>
<div class="ref-opini-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_opini',
            'id',
            'name',
            'created',
            'updated',
        ],
    ]) ?>

</div>
