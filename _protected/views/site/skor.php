<?php
use yii\helpers\Html;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */

?>
<?= DataTables::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'skor',
    ],
]);?>