<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\RefSubDivisi;
use app\modules\parameter\models\RefSubDivisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

/**
 * SubdivisiController implements the CRUD actions for RefSubDivisi model.
 */
class SubdivisiController extends Controller
{

    private $menu = 201;
    private $tahun;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
        
        if(!$this->menu) throw  new NotFoundHttpException('Fill $menu in Controller first.');
        if($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            throw  new NotFoundHttpException('The requested page does not exist.');
        }
        
        $this->tahun = Yii::$app->session->get('tahun', date('Y'));

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action        
    }    

    /**
     * Lists all RefSubDivisi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefSubDivisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $this->tahun,
        ]);
    }

    /**
     * Displays a single RefSubDivisi model.
     * @param integer $unit_id
     * @param integer $divisi_id
     * @param integer $sub_divisi_id
     * @return mixed
     */
    public function actionView($unit_id, $divisi_id, $sub_divisi_id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = $this->findModel($unit_id, $divisi_id, $sub_divisi_id);

        $return = $this->{$render}('view', [
            'model' => $model,
        ]);
        
        if($request->isAjax) return [
            'title'=> "RefSubDivisi #".$model->unit_id,
            'content'=> $return,
            'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
        ];

        return $return;
    }

    /**
     * Creates a new RefSubDivisi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($unit_id = null, $divisi_id = null)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $pjaxUrl = Url::to(['/parameter/unit/sub-divisi', 'unit_id' => $unit_id, 'divisi_id' => $divisi_id], true);

        $model = new RefSubDivisi();
        $model->unit_id = $unit_id;
        $model->divisi_id = $divisi_id;

        $return = $this->renderAjax('_form', [
            'model' => $model,
            'pjaxUrl' => $pjaxUrl
        ]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                return 1;
            }ELSE{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> "Tambah Data",
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }

    /**
     * Updates an existing RefSubDivisi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $unit_id
     * @param integer $divisi_id
     * @param integer $sub_divisi_id
     * @return mixed
     */
    public function actionUpdate($unit_id, $divisi_id, $sub_divisi_id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $pjaxUrl = Url::to(['/parameter/unit/sub-divisi', 'unit_id' => $unit_id, 'divisi_id' => $divisi_id], true);

        $model = $this->findModel($unit_id, $divisi_id, $sub_divisi_id);

        $return = $this->renderAjax('_form', [
            'model' => $model,
            'pjaxUrl' => $pjaxUrl
        ]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                return 1;
            }ELSE{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> "Ubah Data #".$model->unit_id,
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }

    /** 
     * when errors happened at actionCreate or actionUpdate
     * this function will return every error 
     */
    protected function setErrorMessage($errors){
        $return = "";
        foreach($errors as $data){
            $return .= $data['0'].'<br>';
        }
        return $return;
    }

    /**
     * Deletes an existing RefSubDivisi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $unit_id
     * @param integer $divisi_id
     * @param integer $sub_divisi_id
     * @return mixed
     */
    public function actionDelete($unit_id, $divisi_id, $sub_divisi_id)
    {
        $this->findModel($unit_id, $divisi_id, $sub_divisi_id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the RefSubDivisi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $unit_id
     * @param integer $divisi_id
     * @param integer $sub_divisi_id
     * @return RefSubDivisi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($unit_id, $divisi_id, $sub_divisi_id)
    {
        if (($model = RefSubDivisi::findOne(['unit_id' => $unit_id, 'divisi_id' => $divisi_id, 'sub_divisi_id' => $sub_divisi_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => $this->menu])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }  

}
