<?php
use yii\helpers\Html;
use kartik\grid\GridView;

echo Html::a('Tambah Sub Divisi', ['/parameter/subdivisi/create', 'unit_id' => $divisi->unit_id, 'divisi_id' => $divisi->divisi_id], [
    'class' => 'btn btn-sm btn-success',
    'role'=>'modal-remote',
    'title' => 'Tambah Sub Divisi',
]);

echo GridView::widget([
    'id' => 'ref-sub-divisi',    
    'dataProvider' => $dataProvider,
    'responsive'=>true,
    'hover'=>true,     
    'resizableColumns'=>true,
    'panel' => ['type'=>'primary', 'heading'=> "Sub Divisi pada Divisi $divisiName"],
    'responsiveWrap' => false,        
    'toolbar' => [
        [
            // 'content' => '{export}{toggleData}',
        ],
    ],       
    'pager' => [
        'firstPageLabel' => 'Awal',
        'lastPageLabel'  => 'Akhir'
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'options' => ['id' => 'ref-sub-divisi-pjax', 'timeout' => 5000],
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],

        // 'id',
        'sub_divisi_id',
        'nama_sub_divisi',
        [
            'class' => 'kartik\grid\ActionColumn',
            'controller' => 'subdivisi',
            'template' => '{view} {update} {delete}',
            'noWrap' => true,
            'vAlign'=>'top',
            'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-edit"></span>', $url,
                            [  
                                'title' => Yii::t('yii', 'ubah'),
                                'role'=>'modal-remote',
                                'title'=> "Ubah",
                            ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fas fa-eye"></span>', $url,
                            [  
                                'title' => Yii::t('yii', 'lihat'),
                                'role'=>'modal-remote',
                                'title'=> "Lihat",
                            ]);
                    },                        
            ]
        ],
    ],
]);
?>