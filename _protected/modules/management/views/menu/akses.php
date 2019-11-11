<?php

use app\widgets\MenuAkses;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

function akses($id, $menu){
	$akses = \app\models\RefUserMenu::find()->where(['kd_user' => $id, 'menu' => $menu])->one();
	IF($akses) return true;
}
echo MenuAkses::widget([
    'headerMenu' => ['Main Menu', 'Sub Menu', 'Sub Sub Menu', 'Akses'],
    'userGroup' => $model->id,
    'items' =>[
		['name' => 'Pengaturan', 'items' =>[
			['name' => 'Pengaturan Global', 'id' => 101],
			['name' => 'User Management', 'id' => 102],
			['name' => 'Group User dan Akses', 'id' => 103],
			['name' => 'Pengumuman', 'id' => 104],
		]],
		['name' => 'Parameter', 'items' =>[
			['name' => 'Unit-Divisi', 'id' => 201],
			['name' => 'Info Unsur', 'id' => 202],
			['name' => 'Klasifikasi Akun', 'id' => 501],
			['name' => 'Item', 'id' => 502],
		]],
		['name' => 'Penerimaan', 'items' =>[
			['name' => 'Pembelian', 'id' => 402],
			['name' => 'Perolehan Lain', 'id' => 403],
		]],
		['name' => 'Pemakaian', 'items' =>[
			['name' => 'Saldo Awal', 'id' => 404],
			['name' => 'Pemindahan Persediaan', 'id' => 405],
			['name' => 'Acceptance Pemindahan', 'id' => 406],
			['name' => 'Permintaan Pemakaian', 'id' => 408],
			['name' => 'Pemakaian', 'id' => 407],
		]],
		['name' => 'Pembukuan', 'items' =>[
			['name' => 'Opname Persediaan', 'id' => 501],
			['name' => 'Tutup Buku', 'id' => 503],
			['name' => 'Laporan', 'id' => 504],
		]],
		['name' => 'DB', 'items' => [
			['name' => 'Update', 'id' => 801],
			// ['name' => 'Pelaporan', 'id' => 112],
		]],
    ]
]);
?>
<script>
    $('a[id^="access-"]').on("click", function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        var id = $(this).attr('id');
		var status = href.slice(-1);
		status = parseInt(status);
		status == 1 ? confirmMessage = 'Berikan akses?' : confirmMessage = 'Hapus Akses?'
		var confirmation = confirm(confirmMessage);
        object = $(this);
		if(confirmation == true){
			$(this).html('<i class=\"fa fa-spinner fa-spin\"></i>');
			$.ajax({
			    url: href,
			    type: 'post',
			    data: $(this).serialize(),
			    beforeSend: function(){
			            // create before send here
			        },
			        complete: function(){
			            // create complete here
			        },
			    success: function(data) {
					if(data == 1)
					{
						if(status == 1){
							$(object).html('<i class="fas fa-check text-success"></i>');
							href = href.replace('akses=1', 'akses=0');
							$(object).attr('href', href);
						}else{
							$(object).html('<i class="fas fa-lock text-danger"></i>');
							href = href.replace('akses=0', 'akses=1');
							$(object).attr('href', href);
						}
					}else{
						$(object).html('Gagal!');
					}
			    }
			});
		}
    });   


	$(function(){
	
		//assumption: the column that you wish to rowspan is sorted.
		
		//this is where you put in your settings
		var indexOfColumnToRowSpan = 0;
		var $table = $('#myTable');
		
		
		//this is the code to do spanning, should work for any table
		var rowSpanMap = {};
		$table.find('tr').each(function(){
			var valueOfTheSpannableCell = $($(this).children('td')[indexOfColumnToRowSpan]).text();
			$($(this).children('td')[indexOfColumnToRowSpan]).attr('data-original-value', valueOfTheSpannableCell);
			rowSpanMap[valueOfTheSpannableCell] = true;
		});
		
		for(var rowGroup in rowSpanMap){
			var $cellsToSpan = $('td[data-original-value="'+rowGroup+'"]');
			var numberOfRowsToSpan = $cellsToSpan.length;
			$cellsToSpan.each(function(index){
			if(index==0){
				$(this).attr('rowspan', numberOfRowsToSpan);
			}else{
				$(this).hide();
			}
			});
		}
	
	})(); 	
</script>