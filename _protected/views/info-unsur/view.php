<?php

use app\widgets\Card;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\detail\DetailView as KartikDetailView;
use kartik\growl\GrowlAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use  bizley\quill\assets\QuillAsset;
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
                    'heading' => 'Mengenai Sub Unsur Ini ',
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
                    'heading' => 'Penjelasan Suplemen 2 ',
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
        <div class="col-md-4">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Best Practice Docs </th>
                    </tr>
                    <?php foreach ($bestPracticeFile as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a('<i class="fas fa-file-pdf"></i> '.$data->uraian, ['preview', 'file' => $data->file], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Related Docs in Sub Unsur  </th>
                    </tr>
                    <?php foreach ($keterkaitanFile as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a(StringHelper::truncateWords("{$data->kd_unsur_lwn}.{$data->kd_sub_unsur_lwn}.{$data->level_lwn} {$data->uraian}", 5, '...'), ['terkait', 'id' => $data->id], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Only valid if parameter met in </th>
                    </tr>
                    <?php foreach ($keterkaitanUnsur as $key => $data): ?>
                    <tr>
                        <td>
                            <?= Html::a(StringHelper::truncateWords("{$data->kd_unsur_lwn}.{$data->kd_sub_unsur_lwn}.{$data->level_lwn} {$data->uraian}", 5, '...'), ['terkait', 'id' => $data->id], [    
                                'role'=>'modal-remote',
                                'title'=> "Tambah Best Practice",
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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