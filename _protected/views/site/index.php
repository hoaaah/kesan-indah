<?php
use dosamigos\chartjs\ChartJs;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
// use miloschuman\highcharts\Highmaps;
// use yii\web\JsExpression;
/* @var $this yii\web\View */

$this->title = Yii::t('app', Yii::$app->name);

function angka($n) {
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));
    
    // is this a number?
    if(!is_numeric($n)) return false;
    
    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1);
    else if($n>1000000000) return round(($n/1000000000),1);
    else if($n>1000000) return round(($n/1000000),1);
    else if($n>1000) return round(($n/1000),1);
    
    return number_format($n);
}

$kabkotJsUrl = \yii\helpers\Url::to(['/images/id-kabkot.js'], true);
?>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="<?= $kabkotJsUrl ?>"></script>
<!-- <script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script> -->
<?php

//  // To use Highcharts Map Collection, we must register those files separately.
//  // The 'depends' option ensures that the main Highmaps script gets loaded first.
// $this->registerJsFile('http://code.highcharts.com/mapdata/countries/de/de-all.js', [
//     'depends' => 'miloschuman\highcharts\HighchartsAsset'
// ]);

// echo Highmaps::widget([
//     'options' => [
//         'title' => [
//             'text' => 'Highmaps basic demo',
//         ],
//         'mapNavigation' => [
//             'enabled' => true,
//             'buttonOptions' => [
//                 'verticalAlign' => 'bottom',
//             ]
//         ],
//         'colorAxis' => [
//             'min' => 0,
//         ],
//         'series' => [
//             [
//                 'data' => [
//                     ['hc-key' => 'de-ni', 'value' => 0],
//                     ['hc-key' => 'de-hb', 'value' => 1],
//                     ['hc-key' => 'de-sh', 'value' => 2],
//                     ['hc-key' => 'de-be', 'value' => 3],
//                     ['hc-key' => 'de-mv', 'value' => 4],
//                     ['hc-key' => 'de-hh', 'value' => 5],
//                     ['hc-key' => 'de-rp', 'value' => 6],
//                     ['hc-key' => 'de-sl', 'value' => 7],
//                     ['hc-key' => 'de-by', 'value' => 8],
//                     ['hc-key' => 'de-th', 'value' => 9],
//                     ['hc-key' => 'de-st', 'value' => 10],
//                     ['hc-key' => 'de-sn', 'value' => 11],
//                     ['hc-key' => 'de-br', 'value' => 12],
//                     ['hc-key' => 'de-nw', 'value' => 13],
//                     ['hc-key' => 'de-bw', 'value' => 14],
//                     ['hc-key' => 'de-he', 'value' => 15],
//                 ],
//                 'mapData' => new JsExpression('Highcharts.maps["countries/de/de-all"]'),
//                 'joinBy' => 'hc-key',
//                 'name' => 'Random data',
//                 'states' => [
//                     'hover' => [
//                         'color' => '#BADA55',
//                     ]
//                 ],
//                 'dataLabels' => [
//                     'enabled' => true,
//                     'format' => '{point.name}',
//                 ]
//             ]
//         ]
//     ]
// ]);
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= count($skorReassesment) ?><sup style="font-size: 20px"> Pemda</sup></h3>

                    <p>ReAssesment</p>
                </div>
                <div class="icon">
                    <i class="fa fa-paper-plane-o"></i>
                </div>
                <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['asses'], 
                    [
                        'data-toggle'=>"modal",
                        'data-target'=>"#myModal",
                        'data-title'=>"Daftar Pemda Untuk di Assesment",
                        'class'=>'small-box-footer'
                    ]                    
                )?>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= count($skorBimtek) ?><sup style="font-size: 20px"> Pemda</sup></h3>

                    <p>Bimtek SPIP</p>
                </div>
                <div class="icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['bimtek'], 
                    [
                        'data-toggle'=>"modal",
                        'data-target'=>"#myModal",
                        'data-title'=>"Daftar Pemda Untuk di Bimtek SPIP",
                        'class'=>'small-box-footer'
                    ]                    
                )?>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>44</h3>

                    <p>MoU Expiring</p>
                </div>
                <div class="icon">
                    <i class="fa fa-retweet"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>65</h3>

                    <p>Latest Activity</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="peta"></div>
        </div>
    </div class="row">
    <div class="row well">
        <div class="col-lg-3 col-xs-6">
            <?php
                echo ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'height' => 400,
                        'width' => 400
                    ],
                    'data' => [
                        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                        'datasets' => [
                            [
                                'label' => 'Realisasi Kegiatan APD',
                                'backgroundColor' => "rgb(0, 194, 244)",
                                'borderColor' => "rgb(0, 194, 244)",
                                'pointBackgroundColor' => "rgb(0, 194, 244)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgb(0, 194, 244)",
                                'data' => [10, 15, 12, 10, 15, 12]
                            ]
                        ]
                    ]
                ]);            
            ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?php
                echo ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'height' => 400,
                        'width' => 400
                    ],
                    'data' => [
                        'labels' => [$tahun -4, $tahun -3, $tahun -2, $tahun -1, $tahun],
                        'datasets' => [
                            [
                                'label' => 'Opini WTP',
                                'backgroundColor' => "rgb(0, 194, 244)",//"rgba(255,99,132,0.2)",
                                'borderColor' => "rgb(0, 194, 244)",//"rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgb(0, 194, 244)",//"rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgb(0, 194, 244)",//"rgba(255,99,132,1)",
                                'data' => [$opiniGrafik['tahun4'], $opiniGrafik['tahun3'], $opiniGrafik['tahun2'], $opiniGrafik['tahun1'], $opiniGrafik['tahun0']]
                            ]
                        ]
                    ]
                ]);            
            ?>
        </div>
        <div class="col-lg-6 col-xs-12">
            <?php
            echo ChartJs::widget([
                'type' => 'horizontalBar',
                'options' => [
                    'height' => 100,
                    // 'width' => 400
                ],
                'data' => [
                    'labels' => ['Pemda', 'Keu', 'BMD', 'Pendapatan', 'Perencanaan'],
                    'datasets' => [
                        // [
                        //     'label' => 'Anggaran',
                        //     'fillColor' => "rgba(220,220,220,0.5)",
                        //     'strokeColor' => "rgba(220,220,220,1)",
                        //     'pointColor' => "rgba(220,220,220,1)",
                        //     'pointStrokeColor' => "#fff",
                        //     'backgroundColor' => "#f4ff62",
                        //     'data' => [$simdaGrafik['pemda'], $simdaGrafik['keu'], $simdaGrafik['bmd'], $simdaGrafik['pendapatan'], $simdaGrafik['perencanaan']]
                        // ],
                        [
                            'label' => 'Pengguna SIMDA',
                            'fillColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,0.5)",
                            'strokeColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,1)",
                            'pointColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,1)",
                            'pointStrokeColor' => "rgb(0, 194, 244)",//"#fff",
                            'backgroundColor' => "rgb(0, 194, 244)",//"#61ff74",
                            'data' => [$simdaGrafik['pemda'], $simdaGrafik['keu'], $simdaGrafik['bmd'], $simdaGrafik['pendapatan'], $simdaGrafik['perencanaan']]
                        ]
                    ]
                ]
            ]);
            ?>
        </div>  
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="well">
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => function ($model, $key, $index, $widget) {
                        // IF(strlen($model->content) <= 1000){
                            return '
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">'.Html::a($model->title, ['view', 'id' => $model->id], ['class' => '']).'</h3>
                                </div>
                                <div class="panel-body">
                                '.$model->content.'
                                </div>
                                
                            </div>
                            ';                  
                        // }ELSE{
                        //   return '
                        //     <div class="panel panel-success">
                        //         <div class="panel-heading">
                        //             <h3 class="panel-title">'.Html::a($model->title, ['view', 'id' => $model->id], ['class' => '']).'</h3>
                        //         </div>
                        //         <div class="panel-body">
                        //         '.substr($model->content, 0, 1000).Html::a('read more...', ['view', 'id' => $model->id], ['class' => 'btn btn-xs btn-default']).'
                        //         </div>
                            
                        //     </div>
                        //   ';                  
                        // }
                    },
                ]);
                ?> 
            </div>
        </div>
        <div class="col-md-4 well">
            <?php
            echo ChartJs::widget([
                'type' => 'horizontalBar',
                'options' => [
                    'height' => 100,
                    // 'width' => 400
                ],
                'data' => [
                    'labels' => ['Pemda', 'Desa', 'Kompilasi'],
                    'datasets' => [
                        // [
                        //     'label' => 'Anggaran',
                        //     'fillColor' => "rgba(220,220,220,0.5)",
                        //     'strokeColor' => "rgba(220,220,220,1)",
                        //     'pointColor' => "rgba(220,220,220,1)",
                        //     'pointStrokeColor' => "#fff",
                        //     'backgroundColor' => "#f4ff62",
                        //     'data' => [$simdaGrafik['pemda'], $simdaGrafik['keu'], $simdaGrafik['bmd'], $simdaGrafik['pendapatan'], $simdaGrafik['perencanaan']]
                        // ],
                        [
                            'label' => 'Pengguna Siskeudes',
                            'fillColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,0.5)",
                            'strokeColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,1)",
                            'pointColor' => "rgb(0, 194, 244)",//"rgba(151,187,205,1)",
                            'pointStrokeColor' => "rgb(0, 194, 244)",//"#fff",
                            'backgroundColor' => "rgb(0, 194, 244)",//"#61ff74",
                            'data' => [$siskeudesQuery['pemda'], $siskeudesQuery['siskeudes'], $siskeudesQuery['kompilasi']]
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
<?php /*
    <div class="body-content">
    <div class ="row">
    <div class ="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Posisi Kas Harian 10 Hari Terakhir</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <?php
                // $connection = \Yii::$app->db;           
                // $skpd = $connection->createCommand('SELECT Tanggal, SUM(Jumlah) AS Saldo
                // FROM Ta_Kas_Harian 
                // GROUP BY Tanggal
                // ORDER BY Tanggal ASC
                // LIMIT 0, 10
                // ');
                // $query = $skpd->queryAll();
                // foreach($query AS $query){
                //     $labels[] = DATE('d-m', strtotime($query['Tanggal']));
                //     $data[] = $query['Saldo'];
                // }

                // echo ChartJs::widget([
                //     'type' => 'line',
                //     'options' => [
                //         'height' => 400,
                //         'width' => 400
                //     ],
                //     'data' => [
                //         'labels' => $labels,
                //         'datasets' => [
                //             [
                //                 'label' => 'Realisasi',
                //                 'fillColor' => "rgba(151,187,205,0.5)",
                //                 'strokeColor' => "rgba(151,187,205,1)",
                //                 'pointColor' => "rgba(151,187,205,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => $data
                //             ]
                //         ]
                //     ]
                // ]);
                ?>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class ="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Pelunasan Utang (Dalam Jutaan Rupiah)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <?php 
                // echo ChartJs::widget([
                //     'type' => 'bar',
                //     'options' => [
                //         'height' => 400,
                //         'width' => 400
                //     ],
                //     'data' => [
                //         'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                //         'datasets' => [
                //             [
                //                 'label' => 'Anggaran',
                //                 'fillColor' => "rgba(220,220,220,0.5)",
                //                 'strokeColor' => "rgba(220,220,220,1)",
                //                 'pointColor' => "rgba(220,220,220,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => [65, 59, 90, 81, 56, 55, 40]
                //             ],
                //             [
                //                 'label' => 'Realisasi',
                //                 'fillColor' => "rgba(151,187,205,0.5)",
                //                 'strokeColor' => "rgba(151,187,205,1)",
                //                 'pointColor' => "rgba(151,187,205,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => [28, 48, 40, 19, 96, 27, 100]
                //             ]
                //         ]
                //     ]
                // ]);
                ?>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>    
    <!-- /.box -->

    </div>
    </div>
*/ ?>
</div>

<?php 
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs(<<<JS
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

JS
);

$data = json_encode($simdaKeuGeometryData);
// echo $data;
$this->registerJs(<<<JS
// Prepare demo data
// Data is joined to map using value of 'hc-key' property by default.
// See API docs for 'joinBy' for more info on linking data and map.

var data = $data;

// Create the chart
Highcharts.mapChart('peta', {
    chart: {
        map: 'countries/id/id-kabkot'
        // map: 'countries/id/id-all'
    },

    title: {
        text: 'Pengguna Simda Keuangan'
    },

    subtitle: {
        text: 'Source map: <a href="$kabkotJsUrl">Indonesia</a>'
        // text: 'Source map: <a href="http://code.highcharts.com/mapdata/countries/id/id-all.js">Indonesia</a>'
    },

    mapNavigation: {
        enabled: true,
        buttonOptions: {
            verticalAlign: 'bottom'
        }
    },

    colorAxis: {
        min: 0
    },

    series: [{
        data: data,
        name: 'Simda Keuangan',
        states: {
            hover: {
                color: '#BADA55'
            }
        },
        dataLabels: {
            enabled: false,
            format: '{point.name}'
        }
    }]
});

JS
);
?>