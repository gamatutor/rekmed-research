<?php

namespace app\controllers;

use Yii;
use app\models\PasienNextVisit;
use app\models\Kunjungan;
use app\models\PasienNextVisitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;

/**
 * PasienNextVisitController implements the CRUD actions for PasienNextVisit model.
 */
class PasienNextVisitController extends Controller
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
                    'delete' => ['POST','cancel','add'],
                ],

            ],
            'access' => [
                   'class' => AccessControl::className(),
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['index','create', 'update', 'delete','view','list','cancel','add'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','list','cancel','add'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_DOKTER_ADMIN,User::ROLE_DOKTER,
                           ],
                       ]
                   ],
            ],
        ];
    }

    /**
     * Lists all PasienNextVisit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PasienNextVisitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList(){
        $model = PasienNextVisit::find()->leftJoin('pasien','pasien.mr=pasien_next_visit.mr')->where(['pasien.klinik_id'=>Yii::$app->user->identity->klinik_id,'pasien_next_visit.created_by'=>Yii::$app->user->identity->id,'seen'=>0])->andWhere(['<=','next_visit',date('Y-m-d')])->all();
        return $this->renderAjax('list', compact('model'));
    }

    /**
     * Displays a single PasienNextVisit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PasienNextVisit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new PasienNextVisit();

        $model->mr = $id;
        $model->created_by = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Berhasil menambah jadwal kunjungan selanjutnya');
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PasienNextVisit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pasien_schedule_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PasienNextVisit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCancel($id)
    {
        $m = $this->findModel($id);
        $m->seen = 1;
        $m->save();
        \Yii::$app->getSession()->setFlash('success', 'Berhasil membatalkan jadwal kunjungan.');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAdd($id){
        $m = $this->findModel($id);
        $m->seen = 1;
        $m->save();

        $model = new Kunjungan();
        $model->klinik_id = Yii::$app->user->identity->klinik_id;
        $model->tanggal_periksa = date('Y-m-d');
        $model->jam_masuk = date('Y-m-d H:i:s');
        $model->created = date('Y-m-d H:i:s');
        $model->status = 'antri';
        $model->user_input = Yii::$app->user->identity->username;
        $model->user_id = $m->created_by;
        $model->mr = $m->mr;
        $model->dokter_periksa = $m->created_by;
        $model->save();
        \Yii::$app->getSession()->setFlash('success', 'Berhasil Menambahkan ke Antrian');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the PasienNextVisit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PasienNextVisit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PasienNextVisit::findOne($id)) !== null) {
            if($model->created_by == Yii::$app->user->identity->id)
                return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
