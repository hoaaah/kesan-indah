<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\growl\GrowlAsset;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\tabs\TabsX;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit - Divisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-unit-index">
    <?php ob_start() ?>
    <p>
        <?= Html::a('Tambah Ref Unit', ['create'], [
            'class' => 'btn btn-xs btn-success',
            'role'=>'modal-remote',
            'title' => 'Tambah Ref Unit',
        ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ref-unit',    
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
            'options' => ['id' => 'ref-unit-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            'kd_unit_simda',
            'nama_unit',
            // 'alamat',
            // 'kepala_unit',
            // 'nip',
            // 'kecamatan_id',
            // 'kelurahan_id',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{divisi} {view} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'divisi' => function($url, $model){
                            return Html::a('<span class="fas fa-forward"></span> Div', $url,
                            [
                                'id' => 'rek-divisi-'.$model->id,
                                'title' => "Divisi",
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
    
    <?php $content = ob_get_contents(); ob_end_clean(); ?>

    <?php echo TabsX::widget([
        'items' => [
            [
                'label'=>'<i class="fas fa-home"></i> Unit',
                'content' => $content,
                'active' => true,
                'linkOptions' => ['id'=>'unit-tab'],
            ],
            [
                'label'=>'<i class="fas fa-forward"></i> Divisi',
                'content'=> "Ini Divisi",
                'linkOptions' => ['id'=>'divisi-tab']
            ],
            [
                'label'=>'<i class="fas fa-forward"></i> Sub Divisi',
                'content' => 'Ini Sub Divisi',
                'linkOptions' => ['id'=>'sub-divisi-tab']
            ],
        ],
        'position'=>TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels'=>false
    ]); ?>

</div>
<?php 
Modal::begin([
    'id' => 'ajaxCrudModal',
    'title' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();
$this->registerJs(<<<JS
    $("a[id^='rek-divisi-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#unit-tab').removeClass('active');
        $('#unit-tab').attr('aria-selected', 'false');
        $('#divisi-tab').addClass('active');
        $('#divisi-tab').attr('aria-selected', 'true');
        $('#w3-tab0').removeClass('show active');
        $('#w3-tab1').addClass('show active');
        $('#w3-tab1').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#w3-tab1').html(data);
        });
    })
JS
);
?>