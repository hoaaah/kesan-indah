<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\growl\GrowlAsset;
use hoaaah\ajaxcrud\CrudAsset; 
use hoaaah\ajaxcrud\BulkButtonWidget;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefSubUnsurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Informasi Unsur - Sub Unsur';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-sub-unsur-index">

    <?= GridView::widget([
        'id' => 'ref-sub-unsur',    
        'dataProvider' => $dataProvider,
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel' => ['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => '{export}{toggleData}',
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>false,
        'pjaxSettings'=>[
            'options' => ['id' => 'ref-sub-unsur-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'kd_unsur', 
                'width'=>'310px',
                'format' => 'raw',
                'value' =>function($model){
                    return "<b>{$model->kd_unsur} {$model->kdUnsur->name}</b>";
                    //return print_r(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID));
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
            ],
            [
                'label' => 'Kode',
                'width' => '10%',
                'attribute' => 'kd_sub_unsur',
                'value' => function($model){
                    return "{$model->kd_unsur}.{$model->kd_sub_unsur}";
                }
            ],
            'name',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete} {level}',
                'noWrap' => true,
                'vAlign'=>'top',
                'visibleButtons' => [
                    'view' => function($model){
                        return false;
                    },
                    'update' => function($model){
                        return false;
                    },
                    'delete' => function($model){
                        return false;
                    }

                ],
                'buttons' => [
                    'level' => function ($url, $model) {
                        return '<div class="btn btn-group">'.
                        Html::a('L1', ['level', 'lv' => 1, 'id' => $model->id], ['class' => 'btn btn-sm btn-danger']).
                        Html::a('L2', ['level', 'lv' => 2, 'id' => $model->id], ['class' => 'btn btn-sm btn-warning']).
                        Html::a('L3', ['level', 'lv' => 3, 'id' => $model->id], ['class' => 'btn btn-sm btn-success']).
                        Html::a('L4', ['level', 'lv' => 4, 'id' => $model->id], ['class' => 'btn btn-sm btn-info']).
                        Html::a('L5', ['level', 'lv' => 5, 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']).
                        "</div>";
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-edit"></span>', $url,
                            [  
                                'title' => Yii::t('yii', 'ubah'),
                                'role'=>'modal-remote',
                                'title'=> "Ubah",                                 
                                // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                // 'data-method' => 'POST',
                                // 'data-pjax' => 1
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
    ]); ?>
</div>
<?php Modal::begin([
    'id' => 'ajaxCrudModal',
    'title' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    'size' => 'modal-xl',
]);
 
echo '...';
 
Modal::end();
?>