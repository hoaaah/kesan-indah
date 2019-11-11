<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users Management');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p><?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-xs btn-success pull-right']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
            //'{export}',
            //'{toggleData}',
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'username',
            'email:email',
            // status
            [
                'attribute'=>'status',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->getStatusName($data->status);
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::userStatusCss($model->status)];
                }
            ],
            // role
            [
                'attribute'=>'item_name',
                'filter' => $searchModel->rolesList,
                'value' => function ($data) {
                    return $data->roleName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::roleCss($model->roleName)];
                }
            ],
            'refUser.name',
            'refUnit.nama_unit',
            'refSubDivisi.nama_sub_divisi',
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => "Aksi",
                'noWrap' => true,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'View user', 'class'=>'fas fa-eye']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'Manage user', 'class'=>'fas fa-edit']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, 
                        ['title'=>'Delete user', 
                            'class'=>'fas fa-trash',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                                'method' => 'post']
                        ]);
                    }
                ]

            ], // ActionColumn

        ], // columns

    ]); ?>

</div>
