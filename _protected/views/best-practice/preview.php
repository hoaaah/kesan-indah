<?php
use wahyugnc\pdfjs\ViewerPDF;
use yii2assets\pdfjs\PdfJs;
use yii\helpers\Url;

// var_dump(Url::to(['get-file', 'file' => $model->file], true));
// echo PdfJs::widget(['url' => Url::to(['get-file', 'file' => $model->file], true)]) ;
echo PdfJs::widget(['url' => $model->getAbsoluteImageUrl()]) ;
?>