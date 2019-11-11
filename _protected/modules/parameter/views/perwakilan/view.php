<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefPerwakilan */
?>
<div class="ref-perwakilan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
