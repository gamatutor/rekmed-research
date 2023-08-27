<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Dokter;
use app\models\SignupForm;
use app\models\ResetForm;
use app\models\UserSearch;

use app\models\Klinik;
use app\models\ImportUser;
use app\models\Tindakan;
use app\models\KlinikCredit;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                ],
            ],
            'access' => [
                   'class' => AccessControl::className(),
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['index','create', 'update', 'delete','view'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ]
                   ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $transaction = User::getDb()->beginTransaction(); 

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $Dokter = new Dokter();
                $Dokter->user_id = $user->id;
                $Dokter->nama = $user->username;
                if($Dokter->save()) $transaction->commit();
                else {
                    $transaction->rollBack();
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
                return $this->redirect(['user/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $model = new ResetForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->validate();
            if($model->resetPassword()){
                \Yii::$app->getSession()->setFlash('success', 'Berhasil Merubah Passowrd');
                return $this->redirect(['change-password']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Gagal Merubah Passowrd');
                return $this->redirect(['change-password']);
            }
        }
        return $this->render('change_password',compact('model'));
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModelDokter($id)->delete();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    

    public function actionImportPengguna()
    {
        $data = ImportUser::find()->asArray()->all();
        $transaction = ImportUser::getDb()->beginTransaction(); 

        foreach ($data as $key => $value) {
            $email = explode('@', $value['email']);
            $Klinik = new Klinik();
            $Klinik->klinik_nama = "Klinik ".$email[0];
            $Klinik->maximum_row = 100;
            $Klinik->save();
            
            $model_tindakan = new Tindakan();
            $model_tindakan->klinik_id = $Klinik->klinik_id;
            $model_tindakan->nama_tindakan = 'Umum';
            $model_tindakan->biaya_wajib = 1;
            $model_tindakan->tarif_dokter = 0;
            $model_tindakan->tarif_asisten = 0;
            $model_tindakan->created = date('Y-m-d H:i:s');
            $model_tindakan->save();

            $model_credit = new KlinikCredit();
            $model_credit->klinik_id = $Klinik->klinik_id;
            $model_credit->penambahan = 100;
            $model_credit->biaya = 0;
            $model_credit->user_id = Yii::$app->user->identity->id;
            $model_credit->save();
            
            $model = new SignupForm();
            $model->username = $value['email'];
            $model->email = $value['email'];
            $model->password = $value['password_default'];
            $model->klinik_id = $Klinik->klinik_id;
            $model->role = 20;
            $user = $model->signup();

            $Dokter = new Dokter();
            $Dokter->user_id = $user->id;
            $Dokter->nama = $user->username;
            $Dokter->save();
        }

        $transaction->commit();
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelDokter($id)
    {
        if (($model = Dokter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
