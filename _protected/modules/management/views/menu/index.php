<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\growl\GrowlAsset;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\management\models\RefUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);

$this->title = 'Grup dan Akses Grup';
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = 'Grup dan Akses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-user-index">

    <p>
        <?= Html::a('Tambah Grup User', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Program RPJMD",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'group-pjax', 'timeout' => 5000],
        ],  
        'columns' => [
            'id',
            'name',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{akses} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="fas fa-edit"></span>', $url,
                              [  
                                 'title' => 'Edit',
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Ubah Unit",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },                
                        'akses' => function($url, $model){
                            return  Html::a('<i class="fa fa-key bg-white"></i> Akses', ['akses', 'id' => $model->id],
                                [  
                                    'class' => 'btn btn-sm btn-outline-secondary',
                                    'title' => 'Akses',
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModal",
                                    'data-title'=> "Hak Akses ".$model->name,                                 
                                    // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                    // 'data-method' => 'POST',
                                    // 'data-pjax' => 1
                              ]);
                        }
                ]
            ],
        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'title' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg'
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>