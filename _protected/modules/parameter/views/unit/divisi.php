<?php
use yii\helpers\Html;
use kartik\grid\GridView;

echo Html::a('Tambah Divisi', ['/parameter/divisi/create', 'unit_id' => $unit->id], [
    'class' => 'btn btn-sm btn-success',
    'role'=>'modal-remote',
    'title' => 'Tambah Sub Divisi',
]);

echo GridView::widget([
    'id' => 'ref-divisi',    
    'dataProvider' => $dataProvider,
    'responsive'=>true,
    'hover'=>true,     
    'resizableColumns'=>true,
    'panel' => ['type'=>'primary', 'heading'=> "Divisi pada Unit $unitName"],
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
        'options' => ['id' => 'ref-divisi-pjax', 'timeout' => 5000],
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],

        // 'id',
        'divisi_id',
        'nama_divisi',
        [
            'class' => 'kartik\grid\ActionColumn',
            'controller' => 'divisi',
            'template' => '{sub-divisi} {view} {update} {delete}',
            'noWrap' => true,
            'vAlign'=>'top',
            'buttons' => [
                    'sub-divisi' => function($url, $model){
                        return Html::a('<span class="fas fa-forward"></span> Sub', ['/parameter/unit/sub-divisi', 'unit_id' => $model->unit_id, 'divisi_id' => $model->divisi_id],
                        [
                            'id' => 'rek-sub-divisi-'.$model->divisi_id,
                            'title' => "Sub Divisi",
                            'class' => 'btn btn-xs btn-secondary',
                            // 'data-pjax' => 0
                        ]);
                    },
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

$this->registerJs(<<<JS
    $("a[id^='rek-sub-divisi-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#divisi-tab').removeClass('active');
        $('#divisi-tab').attr('aria-selected', 'false');
        $('#sub-divisi-tab').addClass('active');
        $('#sub-divisi-tab').attr('aria-selected', 'true');
        $('#w3-tab1').removeClass('show active');
        $('#w3-tab2').addClass('show active');
        $('#w3-tab2').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#w3-tab2').html(data);
        });
    })
JS
);
?>