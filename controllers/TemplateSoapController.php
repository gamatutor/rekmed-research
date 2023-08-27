<?php

namespace app\controllers;

use Yii;
use app\models\TemplateSoap;
use app\models\TemplateSoapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\components\AccessRule;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\User;


/**
 * TemplateSoapController implements the CRUD actions for TemplateSoap model.
 */
class TemplateSoapController extends Controller
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
                   'only' => ['index','create', 'update', 'delete','view','load-template'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','load-template'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN,User::ROLE_DOKTER_ADMIN,User::ROLE_DOKTER,
                           ],
                       ]
                   ],
            ],
        ];
    }


    public function actionLoadTemplate($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '', 'S'=>'', 'O'=>'', 'A'=>'', 'P'=>'']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, nama_template AS text, subject AS S, object as O, assesment as A, plan AS P')
                ->from('template_soap')
                ->where("nama_template like '%$q%' and user = ".Yii::$app->user->identity->id)
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

    /**
     * Lists all TemplateSoap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSoapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TemplateSoap model.
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
     * Creates a new TemplateSoap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TemplateSoap();
        $model->user = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TemplateSoap model.
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

    /**
     * Deletes an existing TemplateSoap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TemplateSoap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TemplateSoap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TemplateSoap::findOne($id)) !== null) {
            if (Yii::$app->user->identity->role == 10 || Yii::$app->user->identity->id == $model->user)
                return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
