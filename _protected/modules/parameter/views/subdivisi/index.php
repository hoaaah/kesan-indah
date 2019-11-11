<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\growl\GrowlAsset;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefSubDivisiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Sub Divisis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-sub-divisi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Ref Sub Divisi', ['create'], [
            'class' => 'btn btn-xs btn-success',
            'role'=>'modal-remote',
            'title' => 'Tambah Ref Sub Divisi',
        ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ref-sub-divisi',    
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
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ref-sub-divisi-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'unit_id',
            'divisi_id',
            'sub_divisi_id',
            'nama_sub_divisi',
            'pengadaan',

            [
                'class' => 'kartik\grid\ActionColumn',
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
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();
?>