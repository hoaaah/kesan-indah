<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */

?>
<?= GridView::widget([    
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        // 'export' => true, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=> "Coba"    
        ],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],         
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'laporan1-pjax', 'timeout' => 5000],
        ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        'type', 
        'id',
        [
            'label' => 'name',
            'format' => 'raw',
            'value' => function($model){
                $return = '';
                foreach($model['properties'] as $key => $value){
                    if($key == 'name') $return .= "$value";
                }
                return $return;
            }
        ],
        [
            'label' => 'properties',
            'format' => 'raw',
            'value' => function($model){
                return json_encode($model['properties']);
            }
        ],
        [
            'label' => 'geometry',
            'format' => 'raw',
            'value' => function($model){
                return json_encode($model['geometry']);
            }
        ],
        // [
        //     'label' => 'geometry',
        //     'format' => 'raw',
        //     'value' => function($model){
        //         $type = $model['geometry']['type'];
        //         $return = "<b>$type</b></br>";
        //         foreach($model['geometry']['coordinates'][0] as $key => $value){
        //             $return .= "$key = (";
        //             foreach($value as $data){
        //                 $return = var_dump($data);
        //                     // $return .= "$data , ";
        //                 // foreach($data as $coordinate){
        //                 //     $return .= "$coordinate , ";
        //                 // }
        //             }
        //             $return .= ")</br>";
        //         }
        //         return $return;
        //     }
        // ],
    ],
]);?>