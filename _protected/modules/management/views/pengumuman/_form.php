<?php

use bizley\quill\Quill;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaPengumuman */
/* @var $form yii\widgets\ActiveForm */
// First we need to tell CKEDITOR variable where is our external plufin
?>

<div class="ta-pengumuman-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php
            $model->diumumkan_di = 3;
            echo $form->field($model, 'diumumkan_di')->widget(Select2::classname(), [
                'data' => [
                    3 => 'Dashboard'
                ],
                'options' => ['placeholder' => 'Tampilkan Pada Dashboard ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);         
            ?>        
        </div>

        <div class="col-md-3">
        <?php echo $form->field($model, 'sticky')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sticky',
                'offText' => 'Non-Sticky',
            ]        
        ])->label(false); ?>
        </div>

        <div class="col-md-3">
        <?php $model->published = true;
        echo $form->field($model, 'published')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Published',
                'offText' => 'Archived',
            ]        
        ])->label(false); ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Judul ...'])->label(false) ?>

    <?= $form->field($model, 'content')->widget(Quill::class, [
        'theme' => 'snow',
        'toolbarOptions' => 'FULL',
        'options' => [
            'style' => 'min-height:500px;'
            // 'min-height' => '500px'
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
