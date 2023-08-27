<?php

namespace app\controllers;

use Yii;
use app\models\RekamMedis;
use app\models\Bayar;
use app\models\BayarObat;
use app\models\BayarTindakan;
use app\models\Pasien;
use app\models\Kunjungan;
use app\models\BayarSearch;
use app\models\StokObat;
use app\models\Tindakan;
use app\models\RmTindakan;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;

/**
 * BayarController implements the CRUD actions for Bayar model.
 */
class BayarController extends Controller
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
                           'actions' => ['index','create','delete','view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_DOKTER_ADMIN,User::ROLE_DOKTER
                           ],
                       ],
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
     * Lists all Bayar models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new BayarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bayar model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$asal=null)
    {
        $asal = empty($asal) ? 'bayar/index' : $asal; 
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $obat = BayarObat::findAll(['no_invoice'=>$id]);
        $tindakan = BayarTindakan::findAll(['no_invoice'=>$id]);
        $model = $this->findModel($id);
        return $this->renderAjax('view', compact('model','obat','tindakan','asal'));
    }

    /**
     * Creates a new Bayar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$asal=null)
    {
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        $model = new Bayar();
        $model->no_invoice = $model->createNoInvoice();
        $obat = $model->getBayarObat($id);
        $obat_racik = $model->getBayarObatRacik($id);
        $tindakan = $model->getBayarTindakan($id);
        $kunjungan = Kunjungan::find()->joinWith('mr0')->where(['kunjungan_id'=>$id])->asArray()->one();
        $transaction = Bayar::getDb()->beginTransaction(); 
        if ($model->load(Yii::$app->request->post())) {
            $model_rm = RekamMedis::findOne(['kunjungan_id'=>$id]);
            $post_data = Yii::$app->request->post();
            try{
                if(isset($post_data['tindakan']))
                    foreach ($post_data['tindakan'] as $key => $value) {
                        $RmTindakan = new RmTindakan();
                        $RmTindakan->rm_id = $model_rm->rm_id;
                        $RmTindakan->tindakan_id = $value;
                        $d = Tindakan::findOne($value);
                        $RmTindakan->nama_tindakan = $d['nama_tindakan'];
                        $RmTindakan->save();
                    }
                
                $tindakan = $model->getBayarTindakan($id);

                $StokObat = new StokObat();

                $model->kunjungan_id = $id;
                $model->mr = $kunjungan['mr'];
                $model->nama_pasien = $kunjungan['mr0']['nama'];
                $model->alamat = $kunjungan['mr0']['alamat'];
                $model->tanggal_bayar = date('Y-m-d H:i:s');
                $model->subtotal = Yii::$app->request->post()['subtotal'];
                $model->diskon = 0;
                $model->total = Yii::$app->request->post()['subtotal'];
                $model->bayar = str_replace('.', '', $model->bayar);
                $model->kembali = $model->bayar - $model->total;

                $model->save();

                foreach ($obat as $key => $value) {
                    $BayarObat = new BayarObat();
                    $BayarObat->no_invoice = $model->no_invoice;
                    $BayarObat->obat_id = $value['obat_id'];
                    $BayarObat->nama_obat = $value['nama_merk'];
                    $BayarObat->jumlah = $value['jumlah'];
                    $BayarObat->harga_satuan = $value['harga_jual'];
                    $BayarObat->harga_total = $value['jumlah'] * $value['harga_jual'];
                    $BayarObat->is_racik = 0;
                    $BayarObat->save();
                    $StokObat->ubahStok($value['obat_id'],'kurang','Pasien','Pasien : '.$model->nama_pasien.' ('.$model->mr.')',$value['jumlah']);
                }

                foreach ($obat_racik as $key => $value) {
                    $BayarObat = new BayarObat();
                    $BayarObat->no_invoice = $model->no_invoice;
                    $BayarObat->obat_id = $value['obat_id'];
                    $BayarObat->nama_obat = $value['nama_merk'];
                    $BayarObat->jumlah = $value['jumlah'];
                    $BayarObat->harga_satuan = $value['harga_jual'];
                    $BayarObat->harga_total = $value['jumlah'] * $value['harga_jual'];
                    $BayarObat->is_racik = 1;
                    $BayarObat->save();
                }

                foreach ($tindakan as $key => $value) {
                    $BayarTindakan = new BayarTindakan();
                    $BayarTindakan->no_invoice = $model->no_invoice;
                    $BayarTindakan->tindakan_id = $value['tindakan_id'];
                    $BayarTindakan->nama_tindakan = $value['nama_tindakan'];
                    $BayarTindakan->harga = $value['total_tarif'];
                    $BayarTindakan->save();
                }

                $model_kunjungan = $this->findModelKunjungan($model->kunjungan_id);
                $model_kunjungan->status = 'selesai';
                $model_kunjungan->save();

                $rm = RekamMedis::findAll(['kunjungan_id'=>$model->kunjungan_id]);
                foreach ($rm as $rm_val) {
                    $model_rm = $this->findModelRm($rm_val['rm_id']);
                    $model_rm->locked = 1;
                    $model_rm->save();
                }
                $transaction->commit();
                \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
                if(!empty($asal)) return $this->redirect([$asal]);
                return $this->redirect(['site/index']);

            }  catch(\Exception $e) {
                $transaction->rollBack();
                \Yii::$app->getSession()->setFlash('error', 'Terdapat Error!');
                return $this->renderAjax('create', compact('model','obat','obat_racik','tindakan','kunjungan'));
            }
            

            return $this->redirect(['view', 'id' => $model->no_invoice]);
        } else {
            return $this->renderAjax('create', compact('model','obat','obat_racik','tindakan','kunjungan'));
        }
    }

    /**
     * Updates an existing Bayar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->no_invoice]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetTindakan()
    {
        $post_data = Yii::$app->request->post();
        $data = Tindakan::findBySql("SELECT * FROM tindakan WHERE tindakan_id IN (".implode(',', $post_data['ids']).")")->asArray()->all();
        return $this->renderAjax('tindakan',compact('data'));
    }

    /**
     * Deletes an existing Bayar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id,$asal)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model_bayar = $this->findModel($id);
        
        $model_kunjungan = $this->findModelKunjungan($model_bayar->kunjungan_id);
        $model_kunjungan->status = 'antri bayar';
        $model_kunjungan->save();

        $model_rm = RekamMedis::findOne(['kunjungan_id'=>$model_bayar->kunjungan_id]);
        $model_rm->locked = 0;
        $model_rm->save();

        BayarObat::deleteAll(['no_invoice'=>$id]);
        BayarTindakan::deleteAll(['no_invoice'=>$id]);
        $model_bayar->delete();
        if(empty($asal)){
            return $this->redirect(['bayar/index']);
        } else {
            return $this->redirect([$asal]);
        }
        
    }

    /**
     * Finds the Bayar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bayar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bayar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelRm($id)
    {
        if (($model = RekamMedis::findOne($id)) !== null) {
            $model->decryptDulu();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelKunjungan($id)
    {
        if (($model = Kunjungan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function isUserAuthor()
    {   
        $model_bayar = $this->findModel(Yii::$app->request->get('id'));
        return $this->findModelKunjungan($model_bayar->kunjungan_id)->klinik_id == Yii::$app->user->identity->klinik_id;
    }
}
