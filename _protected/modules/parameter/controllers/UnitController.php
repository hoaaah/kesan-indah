<?php

namespace app\modules\parameter\controllers;

use app\models\RefDivisi;
use app\models\RefSubDivisi;
use Yii;
use app\models\RefUnit;
use app\modules\parameter\models\RefUnitSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;

/**
 * UnitController implements the CRUD actions for RefUnit model.
 */
class UnitController extends Controller
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
     * Lists all RefUnit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $this->tahun,
        ]);
    }

    public function actionDivisi($id)
    {
        $unit = RefUnit::findOne(['id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => RefDivisi::find()->where(['unit_id' => $id]),
            'pagination' => ['pageSize' => 0],
        ]);

        // return var_dump($dataProvider);

        return $this->renderAjax('divisi', [
            'dataProvider' => $dataProvider,
            'tahun' => $this->tahun,
            'unitName' => $unit->nama_unit,
            'unit' => $unit
        ]);
    }

    public function actionSubDivisi($unit_id, $divisi_id)
    {
        $divisi = RefDivisi::findOne(['unit_id' => $unit_id, 'divisi_id' => $divisi_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => RefSubDivisi::find()->where(['unit_id' => $unit_id, 'divisi_id' => $divisi_id]),
            'pagination' => ['pageSize' => 0],
        ]);

        return $this->renderAjax('sub-divisi', [
            'dataProvider' => $dataProvider,
            'tahun' => $this->tahun,
            'divisiName' => $divisi->nama_divisi,
            'divisi' => $divisi
        ]);
    }
 
    /**
     * Displays a single RefUnit model.
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
            'title'=> "RefUnit #".$model->id,
            'content'=> $return,
            'footer'=> Html::button('Close',['class'=>'btn btn-secondary float-left','data-dismiss'=>"modal"])
        ];

        return $return;
    }

    /**
     * Creates a new RefUnit model.
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

        $model = new RefUnit();

        $return = $this->renderAjax('_form', [
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
     * Updates an existing RefUnit model.
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

        $return = $this->renderAjax('_form', [
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
                'title'=> "Ubah Data #".$model->id,
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
     * Deletes an existing RefUnit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionKelurahan($id){
        $countKelurahan = \app\models\RefDesa::find()
            ->where(['Kd_Kecamatan'=>$id])
            ->count();
        $kelurahan = \app\models\RefDesa::find()
            ->where(['Kd_Kecamatan'=>$id])
            ->all();
        if($countKelurahan > 0)
        {
            foreach ($kelurahan as $kelurahan) {
                echo "<option value='" .$kelurahan->Kd_Desa. "'>".$kelurahan->Nm_Desa."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }

    /**
     * Finds the RefUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefUnit::findOne($id)) !== null) {
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
