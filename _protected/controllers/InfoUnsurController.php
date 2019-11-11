<?php

namespace app\controllers;

use app\models\BestPracticeFile;
use app\models\Keterkaitan;
use app\models\RefParameterSubUnsur;
use Yii;
use app\models\RefSubUnsur;
use app\models\RefSubUnsurSearch;
use app\models\RefSubUnsurUmum;
use app\models\RefSuplemen2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;

/**
 * InfoUnsurController implements the CRUD actions for RefSubUnsur model.
 */
class InfoUnsurController extends Controller
{

    private $menu = 301;
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
     * Lists all RefSubUnsur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefSubUnsurSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 0;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $this->tahun,
        ]);
    }

    /**
     * Displays a single RefSubUnsur model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = $this->findModel($id);

        $return = $this->{$render}('view', [
            'model' => $model,
        ]);
        
        if($request->isAjax) return [
            'title'=> "RefSubUnsur #".$model->name,
            'content'=> $return,
            'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
        ];

        return $return;
    }

    /**
     * Displays a single RefSubUnsur model.
     * @param integer $id
     * @return mixed
     */
    public function actionLevel($id, $lv = null)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = $this->findModel($id);
        $umum = RefSubUnsurUmum::findOne(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv]);
        $parameters = RefParameterSubUnsur::findAll(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv]);
        $suplemen2 = RefSuplemen2::findOne(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv]);
        $bestPracticeFile = BestPracticeFile::findAll(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv]);
        $keterkaitanFile = Keterkaitan::findAll(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv, 'kategori' => 1]);
        $keterkaitanUnsur = Keterkaitan::findAll(['kd_unsur' => $model->kd_unsur, 'kd_sub_unsur' => $model->kd_sub_unsur, 'level' => $lv, 'kategori' => 2]);

        $return = $this->{$render}('view', [
            'model' => $model,
            'parameters' => $parameters,
            'suplemen2' => $suplemen2,
            'umum' => $umum,
            'bestPracticeFile' => $bestPracticeFile,
            'keterkaitanFile' => $keterkaitanFile,
            'keterkaitanUnsur' => $keterkaitanUnsur,
        ]);
        
        if($request->isAjax) return [
            'title'=> "RefSubUnsur #".$model->name,
            'content'=> $return,
            'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
        ];

        return $return;
    }

    /**
     * Displays a single RefSubUnsur model.
     * @param integer $id
     * @return mixed
     */
    public function actionSuplemen($id)
    {

        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = RefSuplemen2::findOne(['id' => $id]);

        $return = $this->{$render}('_form_suplemen', [
            'model' => $model,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                return $this->redirect(Yii::$app->request->referrer);
                return 1;
            }ELSE{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> "Penjelasan Suplemen",
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }   
    
    public function actionKeterkaitan($id = null, $kd_unsur = null, $kd_sub_unsur = null, $lv = null, $kategori = null)
    {

        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = new Keterkaitan();
        $model->kd_unsur = $kd_unsur;
        $model->kd_sub_unsur = $kd_sub_unsur;
        $model->level = $lv;
        $model->kategori = $kategori;

        $subUnsurList = RefSubUnsur::find()->select(["CONCAT(kd_unsur, '.', kd_sub_unsur) as id", "CONCAT(kd_unsur, '.', kd_sub_unsur, ' ', name) as name"])->asArray()->all();

        $return = $this->{$render}('_form_keterkaitan', [
            'model' => $model,
            'subUnsurList' => ArrayHelper::map($subUnsurList, 'id', 'name'),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                return $this->redirect(Yii::$app->request->referrer);
                return 1;
            }ELSE{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> $kategori == 1 ? "Keterkaitan File" : "Keterkaitan Pemenuhan",
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }   
    
    
    public function actionUmum($id = null, $kd_unsur = null, $kd_sub_unsur = null, $lv = null)
    {

        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = RefSubUnsurUmum::findOne(['id' => $id]);
        if(!$model)
        {
            $model = new RefSubUnsurUmum();
            $model->kd_unsur = $kd_unsur;
            $model->kd_sub_unsur = $kd_sub_unsur;
            $model->level = $lv;
        }
        
        $return = $this->{$render}('_form_umum', [
            'model' => $model,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                return $this->redirect(Yii::$app->request->referrer);
                return 1;
            }ELSE{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> "Penjelasan Umum",
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }

    
    public function actionFile($id = null, $kd_unsur = null, $kd_sub_unsur = null, $lv = null)
    {

        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = new BestPracticeFile();
        $model->kd_unsur = $kd_unsur;
        $model->kd_sub_unsur = $kd_sub_unsur;
        $model->level = $lv;
        
        $return = $this->{$render}('_form_file', [
            'model' => $model,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();
            // return var_dump($image);

            if($model->save()){
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(Yii::$app->request->referrer);
                return 1;
            }else{
                $return = "";
                if($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        } else {
            if($request->isAjax) return [
                'title'=> "Unggah File Best Practice",
                'content'=> $return,
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
            ];
            return $return;
        }
    }   

    public function actionPreview($file)
    {        
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = BestPracticeFile::findOne(['file' => $file]);
        if(!$model) throw new NotFoundHttpException('File Not Found');
        
        $return =  $this->{$render}('preview', ['model' => $model]);

        if($request->isAjax) return [
            'title'=> "Preview File ".$model->name,
            'content'=> $return,
            'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
        ];
        return $return;
    }

    public function actionGetFile($file)
    {
        $model = BestPracticeFile::findOne(['file' => $file]);
        if(!$model) throw new NotFoundHttpException('File Not Found');
        $returnedFile = $model->getImageFile();
        // return var_dump($returnedFile);
        Yii::$app->response->sendFile($returnedFile, $model->filename);
    }

    /**
     * Creates a new RefSubUnsur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = new RefSubUnsur();

        $return = $this->{$render}('_form', [
            'model' => $model,
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
     * Updates an existing RefSubUnsur model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = $this->findModel($id);

        $return = $this->{$render}('_form', [
            'model' => $model,
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
                'title'=> "Ubah Data #".$model->name,
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
     * Deletes an existing RefSubUnsur model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the RefSubUnsur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefSubUnsur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefSubUnsur::findOne($id)) !== null) {
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
