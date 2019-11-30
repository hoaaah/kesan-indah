<?php

use app\widgets\Card;
use hoaaah\ajaxcrud\CrudAsset;
use kartik\detail\DetailView as KartikDetailView;
use kartik\growl\GrowlAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use bizley\quill\assets\QuillAsset;
use yii\helpers\StringHelper;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);
QuillAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */
$lv = Yii::$app->request->get('lv', 1);
$this->title = "{$model->kd_unsur}.{$model->kd_sub_unsur}.{$lv} {$model->name}";
$this->params['breadcrumbs'][] = ['label' => 'Informasi Unsur', 'url' => ['index']];
$this->params['breadcrumbs'][] = "{$this->title} Lv. ".Yii::$app->request->get('lv', 1);
?>
<div class="ref-sub-unsur-view">
    <div class="row">
        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    [
                        'attribute' => 'id',
                        'label' => 'Parameter',
                        'format' => 'raw',
                        'value' => function($model) use ($parameters){
                            $i = 1;
                            $return = '';
                            foreach ($parameters as $key => $value) {
                                $return .= "{$i}. {$value->parameter}</br>";
                                $i++;
                            }
                            return $return;
                        }
                    ],
                ],
            ]) ?>
            
            <?= KartikDetailView::widget([
                'model' => $umum ?? $model,
                'condensed' => true,
                'hover' => true,
                'mode' => KartikDetailView::MODE_VIEW,
                'panel' => [
                    'heading' => 'Mengenai Sub Unsur Ini '.Html::a('<i class="fas fa-pencil-alt"></i>', [
                        'umum', 
                        'id' => $umum ? $umum->id : null, 
                        'kd_unsur' => $umum ? null : $model->kd_unsur,
                        'kd_sub_unsur' => $umum ? null : $model->kd_sub_unsur,
                        'lv' => $umum ? null : $lv,
                    ], [
                        'class' => "text-white float-right",
                        'role'=>'modal-remote',
                        'title'=> "Ubah",
                    ]),
                    'type' => KartikDetailView::TYPE_INFO,
                ],
                'enableEditMode' => false,
                'attributes' => [
                    [
                        'attribute' => $umum ? 'uraian' : 'name',
                        'label' => 'Uraian',
                        'format' => 'raw',
                        'displayOnly' => true,
                    ],
                ]
            ]) ?>
            </br>
            <?= KartikDetailView::widget([
                'model' => $suplemen2,
                'condensed' => true,
                'hover' => true,
                'mode' => KartikDetailView::MODE_VIEW,
                'panel' => [
                    'heading' => 'Penjelasan Suplemen 2 '.Html::a('<i class="fas fa-pencil-alt"></i>', ['suplemen', 'id' => $suplemen2->id], [
                        'class' => "text-white float-right",
                        'role'=>'modal-remote',
                        'title'=> "Ubah",
                    ]),
                    'type' => KartikDetailView::TYPE_INFO,
                ],
                'enableEditMode' => false,
                'attributes' => [
                    [
                        'attribute' => 'pengujian_keterkaitan',
                        'format' => 'raw',
                        'displayOnly' => true,
                    ],
                ]
            ]) ?>
        </div>
        <div class="col-md-3">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Best Practice Docs <?= Html::a('<i class="fas fa-plus"></i>', [
                            'file', 
                            'kd_unsur' => $model->kd_unsur,
                            'kd_sub_unsur' => $model->kd_sub_unsur,
                            'lv' => $lv,
                        ], [
                            'class' => 'float-right text-secondary',
                            'role'=>'modal-remote',
                            'title'=> "Tambah Best Practice",
                        ]) ?> </th>
                    </tr>
                    <?php foreach ($bestPracticeFile as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a('<i class="fas fa-file-pdf"></i> '.$data->uraian, ['preview', 'file' => $data->file], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                            <?= Html::a('<i class="fas fa-times"></i> ', ['deletefile', 'file' => $data->file], [    
                                'class'=> 'text-danger float-right',
                                'title'=> "Hapus Data",
                                'data-confirm' => "Yakin menghapus file?",
                                'data-method' => 'POST',
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Related Docs in Sub Unsur <?= Html::a('<i class="fas fa-plus"></i>', [
                            'keterkaitan',
                            'kategori' => 1, 
                            'kd_unsur' => $model->kd_unsur,
                            'kd_sub_unsur' => $model->kd_sub_unsur,
                            'lv' => $lv,
                        ], [
                            'class' => 'float-right text-secondary',
                            'role'=>'modal-remote',
                            'title'=> "Tambah Best Practice",
                        ]) ?> </th>
                    </tr>
                    <?php foreach ($keterkaitanFile as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a(StringHelper::truncateWords("{$data->kd_unsur_lwn}.{$data->kd_sub_unsur_lwn}.{$data->level_lwn} {$data->uraian}", 5, '...'), ['terkait', 'id' => $data->id], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                            <?= Html::a('<i class="fas fa-times"></i> ', ['deletelink', 'id' => $data->id], [    
                                'class'=> 'text-danger float-right',
                                'title'=> "Hapus Data",
                                'data-confirm' => "Yakin menghapus Keterkaitan?",
                                'data-method' => 'POST',
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Only valid if parameter met in <?= Html::a('<i class="fas fa-plus"></i>', [
                            'keterkaitan',
                            'kategori' => 2, 
                            'kd_unsur' => $model->kd_unsur,
                            'kd_sub_unsur' => $model->kd_sub_unsur,
                            'lv' => $lv,
                        ], [
                            'class' => 'float-right text-secondary',
                            'role'=>'modal-remote',
                            'title'=> "Tambah Best Practice",
                        ]) ?> </th>
                    </tr>
                    <?php foreach ($keterkaitanUnsur as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a(StringHelper::truncateWords("{$data->kd_unsur_lwn}.{$data->kd_sub_unsur_lwn}.{$data->level_lwn} {$data->uraian}", 5, '...'), ['terkait', 'id' => $data->id], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                            <?= Html::a('<i class="fas fa-times"></i> ', ['deletelink', 'id' => $data->id], [    
                                'class'=> 'text-danger float-right',
                                'title'=> "Hapus Data",
                                'data-confirm' => "Yakin menghapus Keterkaitan?",
                                'data-method' => 'POST',
                            ]) ?>
                            <?php
                            // Html::a('<i class="fas fa-check"></i> ', [
                            //     'keterkaitan', 'id' => $data->id,
                            //     'kategori' => $data->kategori, 
                            //     'kd_unsur' => $model->kd_unsur,
                            //     'kd_sub_unsur' => $model->kd_sub_unsur,
                            //     'lv' => $lv,
                            // ], [    
                            //     'class'=> 'text-success float-right',
                            //     'title'=> "Ubah Data",
                            //     'role'=>'modal-remote',
                            // ]);
                             ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-1">
            <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
                <?php foreach($subUnsurList as $subUnsur): ?>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= "{$subUnsur->kd_unsur}.{$subUnsur->kd_sub_unsur}" ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <?=  Html::a("L1", ['level', 'lv' => 1, 'id' => $subUnsur->id], ['class' => 'dropdown-item']) ?>
                            <?=  Html::a("L2", ['level', 'lv' => 2, 'id' => $subUnsur->id], ['class' => 'dropdown-item']) ?>
                            <?=  Html::a("L3", ['level', 'lv' => 3, 'id' => $subUnsur->id], ['class' => 'dropdown-item']) ?>
                            <?=  Html::a("L4", ['level', 'lv' => 4, 'id' => $subUnsur->id], ['class' => 'dropdown-item']) ?>
                            <?=  Html::a("L5", ['level', 'lv' => 5, 'id' => $subUnsur->id], ['class' => 'dropdown-item']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>        
    </div>
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