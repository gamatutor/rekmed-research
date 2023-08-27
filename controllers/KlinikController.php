<?php

namespace app\controllers;

use Yii;
use app\models\Klinik;
use app\models\KlinikCredit;
use app\models\Tindakan;
use app\models\KlinikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;

/**
 * KlinikController implements the CRUD actions for Klinik model.
 */
class KlinikController extends Controller
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
                   'only' => ['index','create', 'update', 'delete','view','clear-rm'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','clear-rm'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ]
                   ],
            ],
        ];
    }

    public function actionClearRm($id)
    {
        $model = $this->findModel($id);
        $model->clearRM();
        \Yii::$app->getSession()->setFlash('success', 'Berhasil mereset Data RM klinik '.$model->klinik_nama);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
    /**
     * Lists all Klinik models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KlinikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Klinik model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCredit($id)
    {
        $model_credit = new KlinikCredit();
        $model = $this->findModel($id);
        if($model_credit->load(Yii::$app->request->post())){
            $model_credit->klinik_id = $id;
            $model_credit->user_id = Yii::$app->user->identity->id;
            $model_credit->save();

            $model->maximum_row += $model_credit->penambahan;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');

            return $this->redirect('index');

        }
        return $this->renderAjax('credit', compact('model','model_credit'));
    }

    /**
     * Creates a new Klinik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Klinik();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model_tindakan = new Tindakan();
            $model_tindakan->klinik_id = $model->klinik_id;
            $model_tindakan->nama_tindakan = 'Konsultasi';
            $model_tindakan->biaya_wajib = 1;
            $model_tindakan->tarif_dokter = 0;
            $model_tindakan->tarif_asisten = 0;
            $model_tindakan->created = date('Y-m-d H:i:s');
            $model_tindakan->save();

            $model_credit = new KlinikCredit();
            $model_credit->klinik_id = $model->klinik_id;
            $model_credit->penambahan = $model->maximum_row;
            $model_credit->biaya = 0;
            $model_credit->user_id = Yii::$app->user->identity->id;
            $model_credit->save();
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
            return $this->redirect('index');
        } else {
            $model->maximum_row = 100;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Klinik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
            return $this->redirect('index');
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Klinik model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $transaction = Klinik::getDb()->beginTransaction(); 
        
        try{
            Tindakan::deleteAll(['klinik_id'=>$id]);
            KlinikCredit::deleteAll(['klinik_id'=>$id]);
            $this->findModel($id)->delete();
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
            $transaction->commit();
            return $this->redirect('index');
        } catch(\Exception $e) {
            $transaction->rollBack();

            \Yii::$app->getSession()->setFlash('error', 'Gagal Menghapus Data, Klinik Sudah Digunakan');
            return $this->redirect('index');
        }

        
    }

    /**
     * Finds the Klinik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Klinik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Klinik::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
