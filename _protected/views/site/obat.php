<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use fedemotta\datatables\DataTables;

$this->title = Yii::$app->name;
/* @var $this yii\web\View */

?>
<?= GridView::widget([    
        'dataProvider' => $dataObatProvider,
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
        // drugsmaster_all
        'id_obat',
        'barcode',
        'kode_binfar',
        'object_name',
        'nama_obat',
        'deskripsi',
        'kekuatan',
        'nama_generik',
        'id_generik',
        'tipe_sediaan',
        'gol_obat', 
        'detil_kemasan',
        'kemasan_unit',
        'satuan_besar_unit',
        'satuan_jual_unit',
        'satuan_klinis',
        'satuan_klinis_unit',
        'org_pembuat',
        'tgl_out',
        'status',
        'kategori',
        'jenis_obat',
        'kategori_objek',
        // innmaster_union
        // 'id_hlp',
        // 'nama_objek',
        // 'sediaan',
        // 'status',
        // drugsmaster_inn
        // 'id',
        // 'generik_object',
        // 'dosage_form',
        // 'strength',
        // 'nama_zat',
        // 'id_obatindikator',
        // 'id_obatprogram',
        // 'status_150item',
        // 'status',
    ],
]);?>