<?php

namespace app\controllers;

use Yii;
use app\components\AccessRule;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\Klinik;
use app\models\ContactForm;
use app\models\Kunjungan;
use app\models\Bayar;
use app\models\RekamMedis;
use app\models\Dokter;
use app\models\ForgotForm;
use app\models\ResetForm;
use app\models\User;
use app\models\UserToken;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error'   => [
                'class'  => 'yii\web\ErrorAction',
                'layout' => 'err',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth'    => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function actionDemo()
    {
        Yii::$app->user->login(User::findByUsername('demoRekmed'), 0);
        return $this->redirect(['site/index']);
    }

    public function actionSearch()
    {
        return $this->render('search');
    }

    public function actionIndex()
    {
        $sisa             = Kunjungan::getSisaRm();
        $dokter           = new Dokter();
        $complete_profile = $dokter->isNothingEmpty();

        $model = new RekamMedis();
        $full  = $model->reachMaxRm() ? true : false;

        $this->layout = 'main_no_portlet';
        $Bayar        = new Bayar();
        $total_hari   = $Bayar->getTotalPemasukanHariIni(Yii::$app->user->identity->klinik_id);
        $total_bulan  = $Bayar->getTotalPemasukanBulanIni(Yii::$app->user->identity->klinik_id);
        $pasien_bulan = Kunjungan::find()->where(['klinik_id' => Yii::$app->user->identity->klinik_id])->andWhere('tanggal_periksa <= (CURDATE() - INTERVAL 90 DAY)')->count();
        $pasien       = Kunjungan::find()->where(['klinik_id' => Yii::$app->user->identity->klinik_id, 'tanggal_periksa' => date('Y-m-d')])->count();
        $kunjungan    = [];
        $farmasi      = [];
        $pembayaran   = [];
        $selesai      = [];
        if (Yii::$app->user->identity->role == '25') {
            $kunjungan  = Kunjungan::find()->joinWith('rekamMedis', true, 'LEFT JOIN')->joinWith('mr0')->where(['kunjungan.dokter_periksa' => Yii::$app->user->identity->id, 'DATE(jam_masuk)' => date('Y-m-d')])->andFilterWhere(['or', ['status' => 'antri'], ['status' => 'diperiksa']])->asArray()->all();
            $farmasi    = Kunjungan::find()->joinWith('mr0')->where(['kunjungan.dokter_periksa' => Yii::$app->user->identity->id, 'status' => 'antri obat'])->asArray()->all();
            $pembayaran = Kunjungan::find()->joinWith('mr0')->where(['kunjungan.dokter_periksa' => Yii::$app->user->identity->id, 'status' => 'antri bayar'])->asArray()->all();
            $selesai    = Kunjungan::find()->joinWith('rekamMedis', true, 'inner JOIN')->joinWith('mr0')->joinWith('bayar')->where(['kunjungan.dokter_periksa' => Yii::$app->user->identity->id, 'status' => 'selesai'])->asArray()->all();
        } elseif (Yii::$app->user->identity->role == '20') {
            $kunjungan  = Kunjungan::find()->joinWith('rekamMedis', true, 'LEFT JOIN')->joinWith('mr0')->where(['kunjungan.klinik_id' => Yii::$app->user->identity->klinik_id, 'DATE(jam_masuk)' => date('Y-m-d')])->andFilterWhere(['or', ['status' => 'antri'], ['status' => 'diperiksa']])->asArray()->all();
            $farmasi    = Kunjungan::find()->joinWith('mr0')->where(['kunjungan.klinik_id' => Yii::$app->user->identity->klinik_id, 'status' => 'antri obat'])->asArray()->all();
            $pembayaran = Kunjungan::find()->joinWith('mr0')->where(['kunjungan.klinik_id' => Yii::$app->user->identity->klinik_id, 'status' => 'antri bayar'])->asArray()->all();
            $selesai    = Kunjungan::find()->joinWith('rekamMedis', true, 'inner JOIN')->joinWith('mr0')->joinWith('bayar')->where(['kunjungan.klinik_id' => Yii::$app->user->identity->klinik_id, 'status' => 'selesai'])->orderBy('tanggal_periksa DESC')->limit(5)->asArray()->all();
            //$selesai = Kunjungan::find()->joinWith('rekamMedis',true,'inner JOIN')->joinWith('mr0')->joinWith('bayar')->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id,'status'=>'selesai'])->orderBy('tanggal_periksa ASC')->limit(5)->asArray()->all();
        }

        $diagnosisDR     = $this->dataDiagnosisDr;
        $diagnosisKlinik = $this->dataDiagnosisKlinik;
        $jlhPasien12Bln  = $this->jlhPasien12Bln;
        $jlhStock        = $this->jlhStock;

        return $this->render('index', compact('jlhPasien12Bln', 'jlhStock', 'diagnosisKlinik', 'diagnosisDR', 'sisa', 'total_hari', 'total_bulan', 'pasien_bulan', 'pasien', 'kunjungan', 'farmasi', 'pembayaran', 'full', 'selesai', 'complete_profile'));
    }

    public function GetJlhPasien12Bln()
    {
        $connection = Yii::$app->db;
        $sql        = "select concat(MONTHNAME(created),', ', YEAR(created)) as bulan, count(*) as jumlah from kunjungan where created >= DATE_ADD(Now(), INTERVAL- 12 MONTH) AND klinik_id = " . Yii::$app->user->identity->klinik_id . " GROUP BY MONTH(created), YEAR(created) ORDER BY YEAR(created) DESC, MONTH(created) DESC";
        $command    = $connection->createCommand($sql);
        $d          = $command->queryAll();
        $data       = ['jlh' => [], 'bulan' => []];
        foreach ($d as $key => $value) {
            $data['jlh'][]   = (int) $value['jumlah'];
            $data['bulan'][] = $value['bulan'];
        }
        return $data;
        // print_r($t); die;
        // select MONTH(created), YEAR(created), count(*) as jumlah from kunjungan where created >= DATE_ADD(Now(), INTERVAL- 12 MONTH) GROUP BY MONTH(created), YEAR(created) ORDER BY YEAR(created) DESC, MONTH(created) DESC
    }


    public function GetJlhStock()
    {
        $connection = Yii::$app->db;
        $sql        = "SELECT obat_id,nama_merk,nama_generik,stok FROM obat where (stok<=30) AND klinik_id = " . Yii::$app->user->identity->klinik_id . " order by stok ASC";
        $command    = $connection->createCommand($sql);
        $d          = $command->queryAll();
        $data       = ['jlh' => [], 'merk' => []];
        foreach ($d as $key => $value) {
            $data['jlh'][]  = (int) $value['stok'];
            $data['merk'][] = $value['nama_merk'];
        }
        return $data;
        // print_r($t); die;
        // select MONTH(created), YEAR(created), count(*) as jumlah from kunjungan where created >= DATE_ADD(Now(), INTERVAL- 12 MONTH) GROUP BY MONTH(created), YEAR(created) ORDER BY YEAR(created) DESC, MONTH(created) DESC
    }



    public function actionLogin()
    {
        // $this->layout = 'login';

        $forgot = new ForgotForm();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->renderPartial('login', [
            'model'  => $model,
            'forgot' => $forgot,
        ]);
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model           = new SignupForm();
        $model->scenario = 'signup';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $klinikModel              = new Klinik;
            $klinikModel->klinik_nama = "Klinik " . $model->username;
            if ($klinikModel->save()) {
                $model->role          = 20;
                $model->apps          = 'WEB';
                $model->klinik_id     = $klinikModel->klinik_id;
                $s                    = $model->signup();
                $modelLogin           = new LoginForm;
                $modelLogin->username = $model->username;
                $modelLogin->password = $model->password;

                $drModel          = new Dokter;
                $drModel->user_id = $s->id;
                $drModel->save();

                $modelLogin->login();
            }
            return $this->redirect(['site/index']);
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function oAuthSuccess($client)
    {
        // get user data from client
        if ($userAttributes = $client->getUserAttributes()) {
            //apps = 'FB' OR apps_id=':appsId' OR
            //print_r($userAttributes);
            //die;
            $userModel = User::Find()->where("apps_id=:appsId OR email =:e", [':appsId' => $userAttributes['id'], ':e' => $userAttributes['email']])->all();
            //print_r($userModel);
            //die;
            if (count($userModel) == 0) //SIGNUP
            {
                $model            = new SignupForm();
                $model->scenario  = 'signup';
                $model->username  = $userAttributes['email'];
                $model->email     = $userAttributes['email'];
                $model->apps      = 'FB';
                $model->apps_id   = $userAttributes['id'];
                $pss              = substr(md5(rand()), 0, 10);
                $model->password  = $pss;
                $model->password2 = $pss;

                $klinikModel              = new Klinik;
                $klinikModel->klinik_nama = "Klinik " . $userAttributes['name'];

                if ($klinikModel->save()) {
                    $model->role      = 20;
                    $model->klinik_id = $klinikModel->klinik_id;
                    $s                = $model->signup();

                    $drModel          = new Dokter;
                    $drModel->user_id = $s->id;
                    $drModel->nama    = "Dr. " . $userAttributes['name'];
                    $drModel->save();

                    $modelLogin           = new LoginForm;
                    $modelLogin->username = $model->username;
                    $modelLogin->password = $model->password;
                    $modelLogin->login();
                }

            } else //SIGNIN
            {
                $modelLogin           = new LoginForm;
                $modelLogin->username = $userAttributes['email'];
                $modelLogin->password = 'randomPassword';
                $modelLogin->login(true);
            }

            return $this->redirect(['site/index']);
        }
    }

    public function actionReset($token)
    {
        $this->layout = 'login';
        $reset        = new ResetForm();
        // get user token and check expiration
        $userToken = new UserToken();
        $userToken = $userToken::findByToken($token, $userToken::TYPE_PASSWORD_RESET);
        if (!$userToken) {
            return $this->render('reset', ["invalidToken" => true]);
        }

        // get user and set "reset" scenario
        $success = false;
        $user    = new User();
        $user    = $user::findOne($userToken->user_id);

        // load post data and reset user password
        if ($reset->load(Yii::$app->request->post())) {
            $reset->resetPasswordByToken($userToken->user_id);
            $userToken->delete();
            $success = true;
        }

        return $this->render('reset', compact("user", "success", "reset"));
    }

    public function actionForgot()
    {
        /** @var \amnah\yii2\user\models\forms\ForgotForm $model */

        // load post data and send email
        $this->layout = 'login';

        $model = new ForgotForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendForgotEmail()) {
            // set flash (which will show on the current page)
            // Yii::$app->session->setFlash("Forgot-success", "Instruksi Telah dikirimkan ke Email Anda");
            echo "Instruksi Telah dikirimkan ke Email Anda. Harap mengecek folder SPAM apabila anda tidak menemukan email baru di kotak masuk anda.";
        } else
            echo "Email yang anda inputkan salah atau tidak terdaftar.";
        exit;

        // return $this->render("forgot", compact("model"));
    }

    public function actionLogout()
    {
        Yii::$app->user->identity->destroySimulationSession();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTerms()
    {
        $this->layout = 'terms';
        return $this->render('terms');
    }

    public function actionBantuan()
    {
        return $this->render('bantuan');
    }

    public function getDataDiagnosisDr()
    {
        $connection = Yii::$app->db;
        $sql        = "SELECT 
                    assesment AS diagnosis,
                    COUNT(1) AS jml 
                  FROM
                    rekam_medis 
                  WHERE rekam_medis.user_id = " . Yii::$app->user->identity->id . " 
                        and (assesment <> '' and assesment is not null and assesment <> '<p>-</p>')
                  GROUP BY assesment 
                  ORDER BY jml DESC LIMIT 10";

        $command = $connection->createCommand($sql);
        $t       = $command->queryAll();
        $d       = [];
        foreach ($t as $key => $value) {
            $decrypt = RekamMedis::sslDecrypt($value['diagnosis']);
            // $decrypt = $value['diagnosis'];
            $d[$key]['name'] = strlen($decrypt) > 50 ? substr($decrypt, 0, 50) . '....' : $decrypt;
            $d[$key]['y']    = intval($value['jml']);
        }
        return $d;
    }

    public function getDataDiagnosisKlinik()
    {
        $connection = Yii::$app->db;
        $sql        = "SELECT 
                    assesment AS diagnosis,
                    COUNT(1) AS jml 
                  FROM
                    rekam_medis 
                    JOIN user ON rekam_medis.user_id = user.id
                  WHERE user.klinik_id = " . Yii::$app->user->identity->klinik_id . "
                        and (assesment <> '' and assesment is not null and assesment <> '<p>-</p>')
                  GROUP BY assesment 
                  ORDER BY jml DESC LIMIT 10";
        $command    = $connection->createCommand($sql);
        $t          = $command->queryAll();
        $d          = [];
        foreach ($t as $key => $value) {
            $decrypt = RekamMedis::sslDecrypt($value['diagnosis']);
            // $decrypt = $value['diagnosis'];
            $d[$key]['name'] = strlen($decrypt) > 50 ? substr($decrypt, 0, 50) . '....' : $decrypt;
            $d[$key]['y']    = intval($value['jml']);
        }
        return $d;
    }

    //public function actionToEncrypt(){
    //    $model = RekamMedis::find()->all();
    //    foreach ($model as $key => $value) {
    //        // $value->encryptDulu();
    //        $value->save();
    //    }
}


