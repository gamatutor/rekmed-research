<?php

namespace app\controllers;

use Yii;
use app\models\Dokter;
use app\models\Klinik;
use app\models\RefKokab;
use app\models\DokterSearch;
use app\models\SignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use app\models\User;
use app\models\RekamMedis;
use yii\web\UploadedFile;
use app\models\RmPenunjang;
use app\models\TemplateSoap;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ActiveDataProvider;
/**
 * DokterController implements the CRUD actions for Dokter model.
 */
class DokterController extends Controller
{
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
                    'delete-dokter' => ['POST'],
                ],
            ],
            'access' => [
                   'class' => AccessControl::className(),
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['index','create', 'update', 'delete','create-dokter','switch-role','switch-role-back','dl-rm','dl-template-soap'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','switch-role','switch-role-back','dl-rm','dl-template-soap'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ],
                       [
                           'actions' => ['update','view','switch-role-back'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_DOKTER,User::ROLE_DOKTER_ADMIN
                           ],
                           
                       ],
                       [
                           'actions' => ['create-dokter', 'delete-dokter','list','switch-role-back'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_DOKTER_ADMIN
                           ],
                           
                       ]
                   ],
            ],
        ];
    }

    /**
     * Lists all Dokter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DokterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        $searchModel = new DokterSearch();
        if(Yii::$app->user->identity->role==User::ROLE_DOKTER_ADMIN)
            $searchModel->klinik_id = Yii::$app->user->identity->klinik_id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDokterBaru()
    {
        $modelDokter = new Dokter;
        $modelUser = new User;

        return $this->render('dokterBaru', ['modelDokter'=>$modelDokter,'modelUser'=>$modelUser,]);
    }

    /**
     * Displays a single Dokter model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id=null)
    {
        $id = empty($id) ? Yii::$app->user->identity->id : $id;
        if(Yii::$app->user->identity->role!=10)
            if(!$this->isUserAuthor($id))
                throw new NotFoundHttpException('Terjadi Kesalahan.');
            
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_klinik' => $this->findModelKlinik(Yii::$app->user->identity->klinik_id),
        ]);
    }

    /**
     * Creates a new Dokter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dokter();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if(isset($model->imageFile)){
                $model->upload();
                $src = 'img/dokter/' . $model->user_id;
                $ext = $model->imageFile->extension;
                $model->foto = "$src.$ext";
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeleteDokter()
    {
        if ((!isset($_POST['id'])) || (Yii::$app->user->identity->role!=User::ROLE_DOKTER_ADMIN))
            throw new NotFoundHttpException('The requested page does not exist.');
        else
            $id = $_POST['id'];

        if (($model = User::findOne($id)) !== null) {
            if ($model->klinik_id == Yii::$app->user->identity->klinik_id)
            {
               if (($model2 = Dokter::findOne($id)) !== null)
                    $model2->delete();

               $model->delete();
            }

            $this->redirect(['dokter/list']);
        }

    }

    public function actionCreateDokter()
    {
        $user = new SignupForm();
        $user->scenario = "signup";
        $model = new Dokter();
        $transaction = User::getDb()->beginTransaction(); 

        if (($model->load(Yii::$app->request->post()))&&($user->load(Yii::$app->request->post()))) {
            $user->role = User::ROLE_DOKTER;
            $user->apps = 'WEB';
            $user->SK = 1;
            $user->klinik_id = Yii::$app->user->identity->klinik_id;
            $user->password2 = $user->password;
            // $user->signup();
            // print_r($user->getErrors());
            // die;

            if (!$userPK=$user->signup())
            {
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
            $userPK = $userPK['id'];
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');


            $valid = RmPenunjang::validasiFile($model->imageFile,'imageOnly');

            if($valid['stat']=='KO'){
                $model->addError('imageFile',$valid['msg']);
                goto tujuanCreate;
            }

            $model->user_id = $userPK;

            if(isset($model->imageFile)){
                $model->upload();
                $src = 'img/dokter/' . $model->user_id;
                $ext = $model->imageFile->extension;
                $model->foto = "$src.$ext";
            }
            if ($model->save())
            {
                $transaction->commit();
                return $this->redirect(['list']);
            }
            else
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                ]);
        } else {
            tujuanCreate:
            $transaction->rollBack();
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Dokter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->identity->role!=10) 
            if(!$this->isUserAuthor($id)) 
                throw new NotFoundHttpException('The requested page does not exist.');
            

        $model = $this->findModel($id);
        $model->scenario = Dokter::SCENARIO_PROFILE;
        $transaction = Dokter::getDb()->beginTransaction(); 

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $valid = RmPenunjang::validasiFile($model->imageFile,'imageOnly');

            if($valid['stat']=='KO'){
                $model->addError('imageFile',$valid['msg']);
                goto tujuanUpdate;
            }
            
            if(isset($model->imageFile)){
                $model->upload();
                $src = 'img/dokter/' . $model->user_id;
                $ext = $model->imageFile->extension;
                $model->foto = "$src.$ext";
            }
            $model->save();
            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        tujuanUpdate:
        $transaction->rollBack();
        return $this->render('update', [
                'model' => $model,
            ]);
    }

    public function actionUpdateKlinik($id)
    {
        if(Yii::$app->user->identity->role!=10) 
            if(!$this->isUserAuthor($id))
                throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModelKlinik(Yii::$app->user->identity->klinik_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
            return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->render('update_klinik', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dokter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionKokab() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $sub_id = $parents[0];
                $out = RefKokab::find()->select('kota_id as id,kokab_nama as name')->where(['provinsi_id'=>$sub_id])->asArray()->all();
                //print_r($out);exit;
                echo json_encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo json_encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Finds the Dokter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dokter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dokter::findOne($id)) !== null) {
            if($model->user->status == 0)
                throw new NotFoundHttpException('The requested page does not exist.');
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelKlinik($id)
    {
        if (($model = Klinik::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Tidak ada Klinik.');
        }
    }

    protected function isUserAuthor($id)
    {   
        return $this->findModel($id)->user_id == Yii::$app->user->identity->id;
    }

    public function actionSwitchRole($id)
    {
        if(Yii::$app->user->identity->role!=10)
            throw new NotFoundHttpException('Terjadi Kesalahan.');

        //is admin
        $dokter = $this->findModel($id);
        $user = User::findByUsername($dokter->user->username);

        $session = Yii::$app->session;

        $session->set('realUsername', Yii::$app->user->identity->username);
        $session->set('switchedUsername', $dokter->user->username);

        Yii::$app->user->login($user, 0);
        \Yii::$app->getSession()->setFlash('success', 'Berhasil Mengganti Session.');
        return $this->redirect(['site/index']);
    }

    public function actionSwitchRoleBack()
    {
        $session = Yii::$app->session;

        if($session->get('realUsername')=='' || $session->get('switchedUsername')=='')
            throw new NotFoundHttpException('Terjadi Kesalahan.');

        $user = User::findByUsername($session->get('realUsername'));  
        
        Yii::$app->user->identity->destroySimulationSession();

        Yii::$app->user->login($user, 0);
        \Yii::$app->getSession()->setFlash('success', 'Berhasil Mengganti Session.');
        return $this->redirect(['site/index']);
    }

    public function actionDlTemplateSoap($dokter)
    {
        $model = TemplateSoap::find()->where(['user'=>$dokter])->all();
        $no = 1;
        foreach ($model as $key => $value) {
            $SOAP[] =[
                'no'=>$no++,
                'nama'=> html_entity_decode( preg_replace('!\s+!', ' ', strip_tags($value->nama_template))),
                'S'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($value->subject))),
                'O'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($value->object))),
                'A'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($value->assesment))),
                'P'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($value->plan))),
            ];
        }

        // echo '<pre>';
        // print_r($SOAP);
        // die;

        $exporter = new CsvGrid([
            'csvFileConfig' => [
                    'cellDelimiter' => "\t",
                    'rowDelimiter' => "\n",
                    'enclosure' => '',
                ],
            'dataProvider' => new ArrayDataProvider([
                    'allModels' => $SOAP
                ]),
            'columns' => [
                [
                    'attribute' => 'no',
                ],
                [
                    'attribute' => 'nama',
                ],
                [
                    'attribute' => 'S',
                ],
                [
                    'attribute' => 'O',
                ],
                [
                    'attribute' => 'A',
                ],
                [
                    'attribute' => 'P',
                ],
            ],
        ]);

        return $exporter->export()->send('dokter_'.$dokter.'_template_soap.csv');
    }

    public function actionDlRm($dokter)
    {
        $rmModel = RekamMedis:: find()->where(['user_id'=>$dokter])->all();
        $no = 1;
        foreach ($rmModel as $key => $rm) {
            $rm->decryptDulu();
            $SOAP[] =[
                'no'=>$no++,
                'S'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($rm->anamnesis))),
                'O'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($rm->pemeriksaan_fisik))),
                'A'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($rm->assesment))),
                'P'=> html_entity_decode(preg_replace('!\s+!', ' ', strip_tags($rm->plan))),
                'waktu'=> date('d-m-Y H:i', strtotime($rm->created)),
            ];
        }

        // echo '<pre>';
        // print_r($SOAP);
        // die;

        $exporter = new CsvGrid([
            'csvFileConfig' => [
                    'cellDelimiter' => "\t",
                    'rowDelimiter' => "\n",
                    'enclosure' => '',
                ],
            'dataProvider' => new ArrayDataProvider([
                    'allModels' => $SOAP
                ]),
            'columns' => [
                [
                    'attribute' => 'no',
                ],
                [
                    'attribute' => 'S',
                ],
                [
                    'attribute' => 'O',
                ],
                [
                    'attribute' => 'A',
                ],
                [
                    'attribute' => 'P',
                ],
                [
                    'attribute' => 'waktu',
                ],
            ],
        ]);

        return $exporter->export()->send('dokter_'.$dokter.'_rm.csv');
    }
}
