<?php

namespace app\controllers;

use Yii;
use app\models\Obat;
use app\models\StokObat;
use app\models\ObatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;

/**
 * ObatController implements the CRUD actions for Obat model.
 */
class ObatController extends Controller
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
                   'only' => ['index','create', 'update', 'delete','view','cari-obat','tambah-obat'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','cari-obat','tambah-obat'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN,User::ROLE_DOKTER_ADMIN,User::ROLE_DOKTER
                           ],
                       ]
                   ],
            ],
        ];
    }

    /**
     * Lists all Obat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Obat model.
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

    public function actionStok($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $StokObat = StokObat::findAll(['obat_id'=>$id]);
        return $this->renderAjax('stok', [
            'model' => $this->findModel($id),
            'stok' => $StokObat
        ]);
    }

    /**
     * Creates a new Obat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Obat();
        $model->klinik_id = Yii::$app->user->identity->klinik_id;
        $model->created = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Obat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        if(isset(Yii::$app->request->post()['Obat']['stok'])){
            if($model->stok != Yii::$app->request->post()['Obat']['stok'])
            {
                $stok_sesudah = Yii::$app->request->post()['Obat']['stok'];
                $StokObat = new StokObat();
                $tipe = $model->stok < $stok_sesudah ? 'tambah' : 'kurang';
                $jumlah = $model->stok < $stok_sesudah ? $stok_sesudah - $model->stok :  $model->stok - $stok_sesudah;
                $StokObat->ubahStok($id,$tipe,'Penyesuaian','Via Update',$jumlah);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Obat model.
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
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menghapus Obat');
        } catch(\Exception $e) {
                \Yii::$app->getSession()->setFlash('error', 'Gagal Menghapus Obat, Karena Sudah Memiliki Data Transaksi');
        }

        return $this->redirect(['index']);
    }

    public function actionTambahObat($tipe=null,$counter=null)
    {
        return $this->renderAjax('tambah_obat',['tipe'=>$tipe,'counter'=>$counter]);
    }

    public function actionCariObat()
    {
        $post_data = Yii::$app->request->post();
        $query = Obat::findBySql("SELECT * 
            FROM obat 
            WHERE klinik_id =  ".Yii::$app->user->identity->klinik_id." 
                AND (LOWER(nama_merk) LIKE LOWER('%".$post_data['keyword']."%')
                OR LOWER(nama_generik) LIKE LOWER('%".$post_data['keyword']."%')
                OR LOWER(pabrikan) LIKE LOWER('%".$post_data['keyword']."%'))
            "
        );

        return json_encode($query->asArray()->all());
    }

    public function actionCari($q=null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $connection = Yii::$app->db;
        if (!is_null($q)) {
            
            $sql = "SELECT obat_id as id, concat('[',golongan,'] ',nama_merk ) as `text` ,dosis, kemasan
                FROM obat 
                WHERE klinik_id =  ".Yii::$app->user->identity->klinik_id." 
                AND (LOWER(nama_merk) LIKE LOWER('%".$q."%')
                    OR LOWER(nama_generik) LIKE LOWER('%".$q."%')
                    OR LOWER(pabrikan) LIKE LOWER('%".$q."%'))
                "
            ;
            $command = $connection->createCommand($sql);
            $data = $command->queryAll();
            
            $out['results'] = array_values($data);
        }

        return $out;
    }

    public function actionKemasanAnak(){
        $kemasans = array_column(\app\models\RmObatAnak::find()->leftJoin('rekam_medis','rm_obat_anak.rm_id=rekam_medis.rm_id')->leftJoin('kunjungan','kunjungan.kunjungan_id=rekam_medis.kunjungan_id')->select(['concat("<option value=\'",kemasan,"\' />") as kemasan'])->distinct('kemasan')->where(['klinik_id'=>Yii::$app->user->identity->klinik_id])->asArray()->all(),'kemasan');
        
        return implode($kemasans,'');
    }
    /**
     * Finds the Obat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Obat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Obat::findOne($id)) !== null) {
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
