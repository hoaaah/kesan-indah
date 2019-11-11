<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bizley\quill\Quill;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\RefSubUnsur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sub-unsur-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'options'=>[
            'enctype'=>'multipart/form-data',
            'onSubmit' => "return false"
        ],
    ]); ?>

    <?= $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['multiple' => false, 'accept' => 'office/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'previewFileType' => 'office',
            'removeClass' => 'btn btn-danger',
            'showCaption' => false,
            // 'uploadUrl' => Url::to(['/site/file-upload']),
            // 'uploadExtraData' => [
            //     'album_id' => 20,
            //     'cat_id' => 'Nature'
            // ],
            // 'maxFileCount' => 10
        ]
    ])->label(false) ?>

    <?= $form->field($model, 'uraian')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-plus"></i>Simpan', ['class' => 'btn btn-primary', 'id' => 'submitButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs(<<<JS
// $('form#{$model->formName()}').on('beforeSubmit',function(e)
// {
//     var \$form = $(this);
//     $.post(
//         \$form.attr("action"), //serialize Yii2 form 
//         \$form.serialize()
//     )
//         .done(function(result){
//             if(result == 1)
//             {
//                 $("#ajaxCrudModal").modal('hide'); //hide modal after submit
//                 // $.pjax.reload({container:'#ref-sub-unsur-pjax'});
//             }else
//             {
//                 $.notify({message: result}, {type: 'danger', z_index: 10031})
//             }
//         }).fail(function(){
//             // $.notify({message: "Server Error, refresh and try again."}, {type: 'danger', z_index: 10031})
//         });
//     return false;
// });


$("#submitButton").on("click", function(e){
    var form = $('form#{$model->formName()}');
    var formData = new FormData(form.get(0));
    var formURL = form.attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : formData,
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function(data)
        {
            $("#submitButton").attr("disabled", true);
        },
        success:function(data) // , textStatus, jqXHR 
        {
            console.log(data)

            if(data == 1)
            {
                $("#ajaxCrudModal").modal('hide'); //hide modal after submit
                // $.pjax.reload({container:'#ref-sub-unsur-pjax'});
            }else
            {
                $.notify({message: data}, {type: 'danger', z_index: 10031})
            }
            
            // $('#importingModal').modal();
            // var modal = $('#importingModal')
            // var title = 'Importing Data' 
            // var href = data.redirect
            // modal.find('.modal-title').html(title)
            // modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            // $.post(href)
            // .done(function( data ) {
            //     modal.find('.modal-body').html(data)
            // });
            return false;
        },
        error: function() 
        {
            console.log("gagal");      
        }
    });        
})

JS
);
?>