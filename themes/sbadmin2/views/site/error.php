<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="text-center">
    <div class="error mx-auto" data-text="<?= $name ?>"><?= $name ?></div>
    <p class="lead text-gray-800 mb-5"><?= nl2br(Html::encode($message)) ?></p>
    <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
    <a href="<?= Yii::$app->homeUrl ?>">← Back to Dashboard</a>
</div>