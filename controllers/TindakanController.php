<?php

namespace app\controllers;

use Yii;
use app\models\Tindakan;
use app\models\TindakanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;

/**
 * TindakanController implements the CRUD actions for Tindakan model.
 */
class TindakanController extends Controller
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //         'access' => [
    //                'class' => AccessControl::className(),
    //                'ruleConfig' => [
    //                    'class' => AccessRule::className(),
    //                ],
    //                'only' => ['index','create', 'update', 'delete','view'],
    //                'rules' => [
    //                    [
    //                        'actions' => ['index','create', 'update', 'delete','view'],
    //                        'allow' => true,
    //                        'roles' => [
    //                            User::ROLE_ADMIN,User::ROLE_DOKTER_ADMIN,
    //                        ],
    //                    ]
    //                ],
    //         ],
    //     ];
    // }

    /**
     * Lists all Tindakan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TindakanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tindakan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tindakan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tindakan();
        $model->created = date('Y-m-d H:i:s');
        $model->klinik_id = Yii::$app->user->identity->klinik_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $model->tarif_dokter = 0;
            $model->tarif_asisten = 0;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tindakan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tindakan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');
        
        try{
            $this->findModel($id)->delete();
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menghapus Pasien');
        } catch(\Exception $e) {
                \Yii::$app->getSession()->setFlash('error', 'Gagal Menghapus Pasien, Karena Sudah Memiliki Data Transaksi');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tindakan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tindakan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tindakan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function isUserAuthor()
    {   
        return $this->findModel(Yii::$app->request->get('id'))->klinik_id == Yii::$app->user->identity->klinik_id;
    }
}
