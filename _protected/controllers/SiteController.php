<?php
namespace app\controllers;

use app\models\User;
use app\models\LoginForm;
use app\models\AccountActivation;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\RefDivisi;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, and password reset.
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // Set Tahun
    protected function getTahun(){
        if(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }
        return $tahun;
    }

    // Set Bulan
    protected function getBulan(){
        if(Yii::$app->session->get('bulan'))
        {
            $tahun = Yii::$app->session->get('bulan');
        }ELSE{
            $tahun = DATE('m');
        }
        return substr("0".$tahun, -2);
    }


    //Untuk QRCODE
    public function actionQr($url){
        $qr = Yii::$app->get('qr');

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $qr->getContentType());

        return $qr
            ->setText($url)
            ->setLabel(Yii::$app->name)
            ->writeString();
    }

    //Choose what year this application will use as default year --@hoaaah
    public function actionTahun($id)
    {
        $session = Yii::$app->session;
        IF($session['tahun']){
            $session->remove('tahun');
        }
        $session->set('tahun', $id);


        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBulan($id)
    {
        $session = Yii::$app->session;
        IF($session['bulan']){
            $session->remove('bulan');
        }
        $session->set('bulan', $id);


        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionListDivisi() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $unit_id = $parents[0];
                $list = \app\models\RefDivisi::find()->andWhere(['unit_id' => $unit_id])->asArray()->all();
                if ($unit_id != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['divisi_id'], 'name' => $account['nama_divisi']];
                        if ($i == 0) {
                            // $selected = $account['divisi_id'];
                        }
                    }
                    // Shows how you can preselect a value
                    return ['output' => $out, 'selected' => $selected];
                }
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionListSubDivisi() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $unit_id = empty($ids[0]) ? null : $ids[0];
            $divisi_id = empty($ids[1]) ? null : $ids[1];
            if ($unit_id != null) {
                $list = \app\models\RefSubDivisi::find()->andWhere(['unit_id' => $unit_id, 'divisi_id' => $divisi_id])->asArray()->all();
                if ($unit_id != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['sub_divisi_id'], 'name' => $account['nama_sub_divisi']];
                        if ($i == 0) {
                            // $selected = $account['divisi_id'];
                        }
                    }
                    // Shows how you can preselect a value
                    return ['output' => $out, 'selected' => $selected];
                }
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionListrek5() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = \app\models\RefPersediaan5::find()->select(['Kd_Rek_5', 'Kd_Rek_4', 'CONCAT(Kd_Rek_4, \'.\', Kd_Rek_5, \' \', Nm_Rek_5) AS Nm_Rek_5'])->andWhere(['Kd_Rek_4' => $id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['Kd_Rek_5'], 'name' => $account['Nm_Rek_5']];
                    if ($i == 0) {
                        // $selected = $account['Kd_Rek_4'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionListrek6() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = ($_POST['depdrop_parents']);
            $list = \app\models\RefPersediaan6::find()->select(['Kd_Rek_6', 'CONCAT(Kd_Rek_4, \'.\', Kd_Rek_5, \' \', Kd_Rek_6, \' \',Nm_Rek_6) AS Nm_Rek_6'])->andWhere(['Kd_Rek_4' => $id[0], 'Kd_Rek_5' => $id[1]])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['Kd_Rek_6'], 'name' => $account['Nm_Rek_6']];
                    if ($i == 0) {
                        // $selected = $account['Kd_Rek_4'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionListrek7() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = ($_POST['depdrop_parents']);
            $list = \app\models\RefPersediaan7::find()->select(['Kd_Rek_7', 'CONCAT(Kd_Rek_4, \'.\', Kd_Rek_5, \' \', Kd_Rek_6, \' \', Kd_Rek_7, \' \',Nm_Rek_7) AS Nm_Rek_7'])->andWhere(['Kd_Rek_4' => $id[0], 'Kd_Rek_5' => $id[1], 'Kd_Rek_6' => $id[2]])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['Kd_Rek_7'], 'name' => $account['Nm_Rek_7']];
                    if ($i == 0) {
                        // $selected = $account['Kd_Rek_4'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    public function actionCoba(){

        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://localhost:8000/siapda-aceh/id-kabkot.json')
            // ->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
            ->send();
        if ($response->isOk) {
            $data = $response->data;
        }

        // return var_dump($data['features'][122]['geometry']['coordinates'][0]);

        $model = $data['features'];
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $model,
            'pagination' => [
            'pageSize' => 100,
        ],
            'sort' => [
                'attributes' => ['id'],
            ],
        ]);

        return $this->render('coba',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionIndex()
    {
        return $this->render("kosong");

    }

    public function actionAsses()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $perwakilanId = Yii::$app->user->identity->perwakilan_id ? : '%';
        $skorPemdaClass = new \app\models\SkorPemda();
        $skorReassesment = $skorPemdaClass->querySkorTampil($tahun, $perwakilanId, '%', 2);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $skorReassesment,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $this->renderAjax('skor', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBimtek()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $perwakilanId = Yii::$app->user->identity->perwakilan_id ? : '%';
        $skorPemdaClass = new \app\models\SkorPemda();
        $skorBimtek = $skorPemdaClass->querySkorTampil($tahun, $perwakilanId, '%', 1);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $skorBimtek,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $this->renderAjax('skor', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Bagian ini untuk menampilkan pengumuman
    public function actionView($id)
    {
        return $this->render('pengumuman', ['model' => \app\models\TaPengumuman::findOne(['id' => $id])]);
    }

    public function actionItemList($q = null, $id = null, $reff = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            Yii::$app->db->createCommand("
                SELECT
                id, CONCAT(IFNULL(barcode, '--'), ' ', uraian, ' <b>(', satuan, ')</b>') AS NAME
                FROM item
                WHERE
                IFNULL(barcode, '--') LIKE '%'
                AND uraian LIKE '%'
                AND satuan LIKE '%'
                AND Kd_Rek_4 LIKE '%'
                AND Kd_Rek_5 LIKE '%'
                AND Kd_Rek_6 LIKE '%'
                AND Kd_Rek_7 LIKE '%'
                ",[
            ]);
            $query = new Query;
            $query->select('id, name AS text')
                ->from('city')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => City::find($id)->name];
        }
        return $out;
    }

    // Bagian ini untuk menampilkan user profile
    public function actionProfile()
    {
        $id = Yii::$app->user->identity->id;
        $model = \app\models\User::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Perubahan disimpan');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('profile', ['model' => $model]);
    }

    public function actionUbahpassword()
    {
        $id = Yii::$app->user->identity->id;
        // load user data
        $model = \app\models\User::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            IF(Yii::$app->security->validatePassword($model->passwordlama, $model->password_hash)){
                $model->setPassword($model->password);
                $model->save();
                Yii::$app->getSession()->setFlash('success',  'Password sudah diganti');
                return $this->redirect(Yii::$app->request->referrer);
            }ELSE{
                Yii::$app->getSession()->setFlash('warning',  'Password lama anda salah');
                return $this->redirect(Yii::$app->request->referrer);
            }

        } else {
            return $this->renderAjax('ubahpwd', [
                'user' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('contact', ['model' => $model]);
        }

        if (!$model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while sending email.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app',
            'Thank you for contacting us. We will respond to you as soon as possible.'));

        return $this->refresh();
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';
        // user is logged in, he doesn't need to login
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // monitor login status
        $successfulLogin = true;

        // posting data or login has failed
        if (!$model->load(Yii::$app->request->post()) || !$model->login()) {
            $successfulLogin = false;
        }

        // if user's account is not activated, he will have to activate it first
        if ($model->status === User::STATUS_INACTIVE && $successfulLogin === false) {
            Yii::$app->session->setFlash('error', Yii::t('app',
                'You have to activate your account first. Please check your email.'));
            return $this->refresh();
        }

        // if user is not denied because he is not active, then his credentials are not good
        if ($successfulLogin === false) {
            return $this->render('login', ['model' => $model]);
        }

        // login was successful, let user go wherever he previously wanted
        return $this->goBack();
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('requestPasswordResetToken', ['model' => $model]);
        }

        if (!$model->sendEmail()) {
            Yii::$app->session->setFlash('error', Yii::t('app',
                'Sorry, we are unable to reset password for email provided.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

        return $this->goHome();
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$model->load(Yii::$app->request->post()) || !$model->validate() || !$model->resetPassword()) {
            return $this->render('resetPassword', ['model' => $model]);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

        return $this->goHome();
    }

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email with link containing account activation token.
     * If activation is not necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary, @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // if validation didn't pass, reload the form to show errors
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('signup', ['model' => $model]);
        }

        // try to save user data in database, if successful, the user object will be returned
        $user = $model->signup();

        if (!$user) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 'We couldn\'t sign you up, please contact us.'));
            return $this->refresh();
        }

        // user is saved but activation is needed, use signupWithActivation()
        if ($user->status === User::STATUS_INACTIVE) {
            $this->signupWithActivation($model, $user);
            return $this->refresh();
        }

        // now we will try to log user in
        // if login fails we will display error message, else just redirect to home page

        if (!Yii::$app->user->login($user)) {
            // display error message to user
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Please try to log in.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Login after sign up failed! User '.Html::encode($user->username).' could not log in.');
        }

        return $this->goHome();
    }

    /**
     * Tries to send account activation email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // sending email has failed
        if (!$model->sendAccountActivationEmail($user)) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app',
                'We couldn\'t send you account activation email, please contact us.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! User '.Html::encode($user->username).' could not sign up.
                Possible causes: verification email could not be sent.');
        }

        // everything is OK
        Yii::$app->session->setFlash('success', Yii::t('app', 'Hello').' '.Html::encode($user->username). '. ' .
            Yii::t('app', 'To be able to log in, you need to confirm your registration.
                Please check your email, we have sent you a message.'));
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try {
            $user = new AccountActivation($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$user->activateAccount()) {
            Yii::$app->session->setFlash('error', Html::encode($user->username). Yii::t('app',
                ' your account could not be activated, please contact us!'));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Success! You can now log in.').' '.
            Yii::t('app', 'Thank you').' '.Html::encode($user->username).' '.Yii::t('app', 'for joining us!'));

        return $this->redirect('login');
    }
}
