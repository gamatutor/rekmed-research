<?php

namespace app\controllers;

use Yii;
//use app\controllers\MyController;
use app\models\AutoComplete;
use app\models\Pasien;
use app\models\TemplateSoap;
use app\models\RmDiagnosis;
use app\models\RmPenunjang;
use app\models\RmDiagnosisBanding;
use app\models\RmObat;
use app\models\RmObatAnak;
use app\models\RmObatRacik;
use app\models\RmObatRacikKomponen;
use app\models\RmTindakan;
use app\models\RekamMedis;
use app\models\Kunjungan;
use app\models\Diagnosis;
use app\models\Obat;
use app\models\Tindakan;
use app\models\Dokter;
use app\models\Klinik;
use app\models\RekamMedisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * RekamMedisController implements the CRUD actions for RekamMedis model.
 */
class RekamMedisController extends Controller
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
                   'only' => ['index','create', 'update', 'delete','view','indexByMr','unduhAllRm','auto-complete-s','auto-complete-o','auto-complete-a','auto-complete-p','rm-ganda'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','indexByMr','unduhAllRm','auto-complete-s','auto-complete-o','auto-complete-a','auto-complete-p'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN,User::ROLE_DOKTER_ADMIN,User::ROLE_DOKTER,
                           ],
                       ],
                       [
                           'actions' => ['rm-ganda'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN,
                           ],
                       ]
                   ],
            ],
        ];
    }

    public function actionIndexByMr($id)
    {
        $rm = RekamMedis::find()->where(['mr'=>$id])->all();
        $pasien = Pasien::findOne($id);
        return $this->render('indexByMr',['rm'=>$rm,'pasien'=>$pasien]);
    }

    public function actionSuratSehat($id){
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('suratSehat',compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "surat_sehat ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat Sehat ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionSuratSakit($id){
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('suratSakit',compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "surat_sakit ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat Sakit ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionSuratRujukan($id){
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('suratRujukan',compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "surat_sakit ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat Sakit ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    /**
     * Lists all RekamMedis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $cariRM = isset($_POST['rm'])? $_POST['rm']:"";

        if($cariRM!="")
            \Yii::$app->getSession()->setFlash('success', 'Pencarian Rekam Medis dengan kata kunci : "'.HTML::encode($cariRM).'"');

        $searchModel = new RekamMedisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$cariRM);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    //------ tambahan Lukman 11-3-2018 ------------>
    
    public function actionHplperbulan()
    {
        $cariRM = isset($_POST['rm'])? $_POST['rm']:"";

        if($cariRM!="")
            \Yii::$app->getSession()->setFlash('success', 'Pencarian Rekam Medis dengan kata kunci : "'.HTML::encode($cariRM).'"');

        $searchModel = new RekamMedisSearch();
        $dataProvider = $searchModel->searchhpl(Yii::$app->request->queryParams,$cariRM);

        return $this->render('hplperbulan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHplperminggu()
    {
        $cariRM = isset($_POST['rm'])? $_POST['rm']:"";

        if($cariRM!="")
            \Yii::$app->getSession()->setFlash('success', 'Pencarian Rekam Medis dengan kata kunci : "'.HTML::encode($cariRM).'"');

        $searchModel = new RekamMedisSearch();
        $dataProvider = $searchModel->searchhplminggu(Yii::$app->request->queryParams,$cariRM);

        return $this->render('hplperminggu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    //------ end of tambahan 11-3-2018 ------------>
    

    public function actionErrorMaxRm()
    {
        return $this->render('error_max_rm');
    }

    /**
     * Displays a single RekamMedis model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $this->layout = 'main_no_portlet';
        $model = $this->findModel($id);
        $histori_rm = RekamMedis::findAll(['mr'=>$model->mr]);

        $rm_diagnosis = RmDiagnosis::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_diagnosis_banding = RmDiagnosisBanding::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obat = RmObat::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_tindakan = RmTindakan::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik = RmObatRacik::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik_komponen = [];
        foreach ($rm_obatracik as $key => $value) {
            $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::find()->where(['racik_id'=>$value['racik_id']])->asArray()->all();
        }
        $pasien = Pasien::findOne(['mr'=>$model->mr]);
        
        $data_penunjang = RmPenunjang::findAll(['rm_id'=>$id]);
        return $this->render('view', compact('model','rm_diagnosis','rm_diagnosis_banding','rm_obat','rm_obatracik','rm_obatracik_komponen','rm_tindakan','pasien','data_penunjang','histori_rm'));
    }

    public function actionCetakResep($id)
    {
        $this->layout = 'main_no_portlet';
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');
        $model = $this->findModel($id);
        $pasien = Pasien::findOne($model->mr);
        $rm_obat = RmObat::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik = RmObatRacik::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik_komponen = [];
        foreach ($rm_obatracik as $key => $value) {
            $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::find()->where(['racik_id'=>$value['racik_id']])->asArray()->all();
        }
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);
        return $this->render('resep',compact('dokter','rm_obat','rm_obatracik','rm_obatracik_komponen','pasien','model','klinik'));
    }

    public function actionCheckObat($kunjungan_id,$asal)
    {
        
        $this->layout = 'main_no_portlet';
        $id = Yii::$app->security->decryptByKey( utf8_decode($kunjungan_id), Yii::$app->params['kunciInggris'] );
        
        if(!$this->isUserAuthorCreate()) 
            throw new NotFoundHttpException('The requested page does not exist.');
        $rm = RekamMedis::findOne(['kunjungan_id'=>$id]);

        $model = $this->findModel($rm['rm_id']);
        $model_kunjungan = Kunjungan::find()->joinWith('mr0')->where(['kunjungan_id'=>$id])->one();
        $histori_rm = RekamMedis::findAll(['mr'=>$model_kunjungan->mr]);

        if(Yii::$app->request->post()){
            $transaction = RekamMedis::getDb()->beginTransaction(); 
            $post_data = Yii::$app->request->post();
            
            try{
                $berhasil = true;
                $this->resetRmKomponen($rm['rm_id'],true);
                
                $berhasil = $berhasil && $model->save();
                $berhasil = $berhasil && $this->saveDataRm($post_data,$berhasil,$model);

                if($berhasil){
                    $transaction->commit();
                    \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $id, Yii::$app->params['kunciInggris'] ));
                    if(isset($post_data['Simpan'])){
                        return $this->redirect(['check-obat', 'kunjungan_id' => $id,'asal'=>$asal]);
                    } elseif(isset($post_data['Selesai'])) {
                        $model_kunjungan = $this->findModelKunjungan($model->kunjungan_id);
                        $model_kunjungan->status = 'antri bayar';
                        $berhasil = $berhasil && $model_kunjungan->save();

                        return $this->redirect([$asal]);
                    }
                } else {
                    throw new \Exception("Terdapat Error");
                }
                
            }  catch(\Exception $e) {
                $transaction->rollBack();
                //throw $e;
                \Yii::$app->getSession()->setFlash('error', 'Terdapat Error!');
                return $this->render('check_obat', $this->prepareFailData($model,$post_data,$kunjungan,$histori_rm));
            }
            
        }
        
        $rm_obat = RmObat::find()->where(['rm_id'=>$rm['rm_id']])->asArray()->all();
        $rm_obatracik = RmObatRacik::find()->where(['rm_id'=>$rm['rm_id']])->asArray()->all();
        $rm_obatracik_komponen = [];
        foreach ($rm_obatracik as $key => $value) {
            $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::find()->where(['racik_id'=>$value['racik_id']])->asArray()->all();
        }
        
        $kunjungan = $model_kunjungan;
        return $this->render('check_obat', compact('model','kunjungan','rm','rm_obat','rm_obatracik','rm_obatracik_komponen'));
    }

    public function actionUnduhAllRm()
    {
        set_time_limit(5000000);
        ini_set('max_execution_time', 5000000);
        ini_set("pcre.backtrack_limit", "5000000");

        //$rms = RekamMedis::find()->leftJoin('user','rekam_medis.user_id=user.id')->leftJoin('kunjungan','rekam_medis.kunjungan_id=kunjungan.kunjungan_id')->where(['user.klinik_id'=>Yii::$app->user->identity->klinik_id])->andwhere(['between','kunjungan.tanggal_periksa','2020-06-01','2020-06-30'])->all();
        $rms = RekamMedis::find()->leftJoin('user','rekam_medis.user_id=user.id')->where(['user.klinik_id'=>Yii::$app->user->identity->klinik_id])->all();
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $c = [];
        foreach ($rms as $id => $model) {
            $model->decryptDulu();
            $rm_diagnosis = RmDiagnosis::find()->where(['rm_id'=>$id])->asArray()->all();
            $rm_diagnosis_banding = RmDiagnosisBanding::find()->where(['rm_id'=>$id])->asArray()->all();
            $rm_obat = RmObat::find()->where(['rm_id'=>$id])->asArray()->all();
            $rm_tindakan = RmTindakan::find()->where(['rm_id'=>$id])->asArray()->all();
            $rm_obatracik = RmObatRacik::find()->where(['rm_id'=>$id])->asArray()->all();
            $rm_obatracik_komponen = [];
            foreach ($rm_obatracik as $key => $value) {
                $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::find()->where(['racik_id'=>$value['racik_id']])->asArray()->all();
            }
            $pasien = Pasien::findOne(['mr'=>$model->mr]);

            $c[] = $this->renderPartial('unduh',compact('model','rm_diagnosis','rm_diagnosis_banding','rm_obat','rm_obatracik','rm_obatracik_komponen','rm_tindakan','pasien'));
        }
        $content = implode('<pagebreak />', $c);
        if(count($c)==0)
            return "Rekam Medis tidak ditemukan.";

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "RM ".$klinik->klinik_nama.".pdf",
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Rekam Medis ".$klinik->klinik_nama],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>["Rekam Medis, ".$klinik->klinik_nama], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
        
    }


    public function actionUnduhRm($id)
    {
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $this->layout = 'main_no_portlet';
        $model = $this->findModel($id);

        $rm_diagnosis = RmDiagnosis::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_diagnosis_banding = RmDiagnosisBanding::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obat = RmObat::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_tindakan = RmTindakan::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik = RmObatRacik::find()->where(['rm_id'=>$id])->asArray()->all();
        $rm_obatracik_komponen = [];
        foreach ($rm_obatracik as $key => $value) {
            $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::find()->where(['racik_id'=>$value['racik_id']])->asArray()->all();
        }
        $pasien = Pasien::findOne(['mr'=>$model->mr]);

        $content = $this->renderPartial('unduh',compact('model','rm_diagnosis','rm_diagnosis_banding','rm_obat','rm_obatracik','rm_obatracik_komponen','rm_tindakan','pasien'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "RM ".$pasien->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Rekam Medis ".$pasien->mr." ".$model->created],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>["Rekam Medis, No.RM: ".$pasien->mr.", Tanggal Periksa:".$model->created], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    /**
     * Creates a new RekamMedis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($kunjungan_id)
    {
        $kunjungan_id = Yii::$app->security->decryptByKey( utf8_decode($kunjungan_id), Yii::$app->params['kunciInggris'] );     
        $model = new RekamMedis();
        if($model->reachMaxRm())
            return $this->redirect('error-max-rm');
        
        $this->layout = 'main_no_portlet';
        $kunjungan = Kunjungan::find()->joinWith('mr0')->where(['kunjungan_id'=>$kunjungan_id])->one();
        
        if(!$kunjungan->belongsToDr) 
            throw new NotFoundHttpException('RM ini milik '. $kunjungan->dokter0->user->readableName.', Anda tidak memiliki hak untuk mengubah RM ini.');

        $model->mr = $kunjungan->mr0->mr;
        $histori_rm = RekamMedis::findAll(['mr'=>$kunjungan->mr0->mr]);

        //isi tinggi badan dan berat badan terakhir
        if(count($histori_rm)>0)
        {
            $prevRM = end($histori_rm);

            $model->berat_badan = $prevRM->berat_badan;
            $model->tinggi_badan = $prevRM->tinggi_badan;
        }

        $model->user_id = Yii::$app->user->identity->id;
        $model->kunjungan_id = $kunjungan_id;
        $model->created = date('Y-m-d H:i:s');
        $transaction = RekamMedis::getDb()->beginTransaction(); 
        $post_data = Yii::$app->request->post();
        if ($model->load($post_data)) {
            try{
                //simpan template
                if ($post_data['RekamMedis']['addToTemplate']){
                    $templateModel = new TemplateSoap();
                    $templateModel->user = Yii::$app->user->identity->id;
                    $templateModel->nama_template = ($post_data['RekamMedis']['templateName']=='')? strip_tags($post_data['RekamMedis']['assesment']):$post_data['RekamMedis']['templateName'];
                    $templateModel->subject = $post_data['RekamMedis']['anamnesis'];
                    $templateModel->object = $post_data['RekamMedis']['pemeriksaan_fisik'];
                    $templateModel->assesment = $post_data['RekamMedis']['assesment'];
                    $templateModel->plan = $post_data['RekamMedis']['plan'];
                    $templateModel->created = date('Y-m-d H:i:s');
                    $templateModel->save();
                }

                $berhasil = true;
                $pembagi = (($model->tinggi_badan/100) * ($model->tinggi_badan/100));
                if($pembagi>0)
                    $model->bmi = $model->berat_badan / $pembagi;

                // simpan data alergi
                $model->mr0->load($post_data);
                $berhasil = $berhasil && $model->mr0->save();

                $berhasil = $berhasil && $model->save();
                $berhasil = $berhasil && $this->saveDataRm($post_data,$berhasil,$model);
                if($berhasil){
                    $transaction->commit();
                    \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
                    $rm_id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));
                    $model_kunjungan = $this->findModelKunjungan($model->kunjungan_id);
                    if(isset($post_data['SimpanNext'])){
                        $model_kunjungan->status = 'diperiksa';
                        $berhasil = $berhasil && $model_kunjungan->save();
                        
                        return $this->redirect(['update', 'id' => $rm_id,'#'=>$post_data['SimpanNext']]);
                    }
                    elseif(isset($post_data['Simpan'])){
                        $model_kunjungan->status = 'diperiksa';
                        $berhasil = $berhasil && $model_kunjungan->save();
                        
                        return $this->redirect(['update', 'id' => $rm_id]);
                    } elseif(isset($post_data['Selesai'])) {
                        $model_kunjungan->jam_selesai = date('Y-m-d H:i:s');
                        $model_kunjungan->status = (isset($post_data['adv'])&&$post_data['adv']=='on')? 'antri obat':'selesai';
                        $berhasil = $berhasil && $model_kunjungan->save();

                        return $this->redirect(['view', 'id' => $rm_id]);
                    }
                } else {
                    throw new \Exception("Terdapat Error");
                }
                
            }  catch(\Exception $e) {
                $transaction->rollBack();
                //throw $e;
                \Yii::$app->getSession()->setFlash('error', 'Terdapat Error!');

                return $this->render('create', $this->prepareFailData($model,$post_data,$kunjungan,$histori_rm));
            }
            
        } else {
            return $this->render('create', compact('model','kunjungan','histori_rm'));
        }
    }

    /**
     * Updates an existing RekamMedis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $encryptedID = $id;
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        $model = $this->findModel($id);

        if(!$this->isUserAuthor() || $model->locked) 
        {
            \Yii::$app->getSession()->setFlash('error', 'Rekam Medis Sudah Terkunci.');
            return $this->redirect(['rekam-medis/view','id'=>$encryptedID]);
        }

        $kunjungan = Kunjungan::find()->joinWith('mr0')->where(['kunjungan_id'=>$model->kunjungan_id])->one();
        
        if(!$kunjungan->belongsToDr) 
            throw new NotFoundHttpException('RM ini milik '. $kunjungan->dokter0->user->readableName.', Anda tidak memiliki hak untuk mengubah RM ini.');

        $histori_rm = RekamMedis::findAll(['mr'=>$kunjungan->mr0->mr]);

        // $this->layout = 'main_no_portlet';
        $transaction = RekamMedis::getDb()->beginTransaction(); 
        $model->modified = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post())) {
            $post_data = Yii::$app->request->post();
            try{
                //simpan template
                if ($post_data['RekamMedis']['addToTemplate']){
                    $templateModel = new TemplateSoap();
                    $templateModel->user = Yii::$app->user->identity->id;
                    $templateModel->nama_template = ($post_data['RekamMedis']['templateName']=='')? strip_tags($post_data['RekamMedis']['assesment']):$post_data['RekamMedis']['templateName'];
                    $templateModel->subject = $post_data['RekamMedis']['anamnesis'];
                    $templateModel->object = $post_data['RekamMedis']['pemeriksaan_fisik'];
                    $templateModel->assesment = $post_data['RekamMedis']['assesment'];
                    $templateModel->plan = $post_data['RekamMedis']['plan'];
                    $templateModel->save();
                }

                $berhasil = true;
                $this->resetRmKomponen($id);
                
                $pembagi = (($model->tinggi_badan/100) * ($model->tinggi_badan/100));
                if($pembagi>0)
                    $model->bmi = $model->berat_badan / $pembagi;

                // simpan data alergi
                $model->mr0->load($post_data);
                $berhasil = $berhasil && $model->mr0->save();

                $berhasil = $berhasil && $model->save();
                $berhasil = $berhasil && $this->saveDataRm($post_data,$berhasil,$model);

                if($berhasil){
                    $transaction->commit();
                    \Yii::$app->getSession()->setFlash('success', 'Berhasil Menyimpan Data');
                    $rm_id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));
                    if(isset($post_data['SimpanNext'])){
                        return $this->redirect(['update', 'id' => $rm_id,'#'=>$post_data['SimpanNext']]);
                    }
                    elseif(isset($post_data['Simpan'])){
                        return $this->redirect(['update', 'id' => $rm_id]);
                    } elseif(isset($post_data['Selesai'])) {
                        $model_kunjungan = $this->findModelKunjungan($model->kunjungan_id);
                        $model_kunjungan->jam_selesai = date('Y-m-d H:i:s');
                        $model_kunjungan->status = (isset($post_data['adv'])&&$post_data['adv']=='on')? 'antri obat':'selesai';
                        $berhasil = $berhasil && $model_kunjungan->save();

                        return $this->redirect(['view', 'id' => $rm_id]);
                    }
                } else {
                    throw new \Exception("Terdapat Error");
                }
                
            }  catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
                \Yii::$app->getSession()->setFlash('error', 'Terdapat Error!');
                return $this->render('update', $this->prepareFailData($model,$post_data,$kunjungan,$histori_rm));
            }
            
        } else {
            $rm_diagnosis_temp = RmDiagnosis::findAll(['rm_id'=>$model->rm_id]);
            $rm_diagnosis_id = [];
            $rm_diagnosis_text = [];
            foreach ($rm_diagnosis_temp as $key => $value) {
                $rm_diagnosis_id[$key] = empty($value['kode']) ? $value['nama_diagnosis'] : $value['kode'];
                $rm_diagnosis_text[$key]  = empty($value['kode']) ? $value['nama_diagnosis'] : $value['kode'].' - '.$value['nama_diagnosis'];
            }

            $rm_diagnosis_banding_temp = RmDiagnosisBanding::findAll(['rm_id'=>$model->rm_id]);

            $rm_diagnosis_banding_id = [];
            $rm_diagnosis_banding_text = [];
            foreach ($rm_diagnosis_banding_temp as $key => $value) {
                $rm_diagnosis_banding_id[$key] = empty($value['kode']) ? $value['nama_diagnosis'] : $value['kode'];
                $rm_diagnosis_banding_text[$key]  = empty($value['kode']) ? $value['nama_diagnosis'] : $value['kode'].' - '.$value['nama_diagnosis'];
            }

            $rm_tindakan_temp = RmTindakan::findAll(['rm_id'=>$model->rm_id]);
            $rm_tindakan = [];
            foreach ($rm_tindakan_temp as $key => $value) {
                $rm_tindakan[$key] = $value['tindakan_id'];
            }

            $rm_obat = RmObat::findAll(['rm_id'=>$model->rm_id]);
            $rm_obatracik = RmObatRacik::findAll(['rm_id'=>$model->rm_id]);
            $rm_obatracik_komponen = [];
            foreach ($rm_obatracik as $key => $value) $rm_obatracik_komponen[$value['racik_id']] = RmObatRacikKomponen::findAll(['racik_id'=>$value['racik_id']]);
            $data_exist = [];
            return $this->render('update', compact('model','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','data_exist','histori_rm'));
        }
    }

    /**
     * Deletes an existing RekamMedis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');
        
        try{
            $id = Yii::$app->security->decryptByKey( utf8_decode(Yii::$app->request->get('id')), Yii::$app->params['kunciInggris'] );
            
            $this->resetRmKomponen($id);
            $this->findModel($id)->delete();
            
            \Yii::$app->getSession()->setFlash('success', 'Berhasil Menghapus Rekam Medis');
        } catch(\Exception $e) {
                \Yii::$app->getSession()->setFlash('error', 'Gagal Menghapus Rekam Medis, Karena Sudah Memiliki Data Transaksi');
        }

        

        return $this->redirect(['index']);
    }

    public function actionDeletePenunjang($id)
    {
        $model = $this->findModelPenunjang(Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] ));
        $rm_id = $model->rm_id;
        if(!$this->isUserAuthorPenunjang($rm_id)) 
            throw new NotFoundHttpException('The requested page does not exist.');
        unlink($model->path);
        $model->delete();

        return $this->redirect(['upload','id'=>utf8_encode(Yii::$app->security->encryptByKey( $rm_id, Yii::$app->params['kunciInggris'] ))]);
    }

    public function actionUpload($id)
    {
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $fileName = 'file';
        $uploadPath = 'rm_penunjang';

        if (isset($_FILES[$fileName])) {
            
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            $valid = RmPenunjang::validasiFile($file);

            if($valid['stat']=='KO'){
                header("HTTP/1.0 400 Bad Request");
                die($valid['msg']);
            }

            $random_str = Yii::$app->security->generateRandomString(5);
            $model = new RmPenunjang();
            $model->rm_id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
            $file->name = str_replace(' ', '_', $file->name);
            $model->path = $uploadPath . '/' . $random_str.$file->name;
            $model->save();

            if ($file->saveAs($uploadPath . '/' . $random_str.$file->name)) {

                echo \yii\helpers\Json::encode($file);
            }
        } else {
            $data = RmPenunjang::findAll(['rm_id'=>Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] )]);
            return $this->render('upload',compact('id','data'));
        }

        return false;
    }

    private function prepareFailData($model,$post_data,$kunjungan,$histori_rm)
    {
        $rm_diagnosis_id = [];
        $rm_diagnosis_text = [];
        if(isset($post_data['diagnosis']))
        foreach ($post_data['diagnosis'] as $key => $value) {
            $rm_diagnosis_id[$key] = $value;
            $diagnosis = Diagnosis::findOne(['kode'=>$value]);
            $rm_diagnosis_text[$key]  = empty($diagnosis) ? $value : $value.' - '.$diagnosis['nama'];
        }

        $rm_diagnosis_banding_id = [];
        $rm_diagnosis_banding_text = [];
        if(isset($post_data['diagnosis_banding']))
        foreach ($post_data['diagnosis_banding'] as $key => $value) {
            $rm_diagnosis_banding_id[$key]= $value;
            $diagnosis = Diagnosis::findOne(['kode'=>$value]);
            $rm_diagnosis_banding_text[$key]  = empty($diagnosis) ? $value : $value.' - '.$diagnosis['nama'];
        }

        $rm_tindakan = [];
        if(isset($post_data['tindakan']))
        foreach ($post_data['tindakan'] as $key => $value) {
            $rm_tindakan[$key] = $value;
        }
        $rm_obat = [];
        if(isset($post_data['Obat'])){
            foreach ($post_data['Obat']['jumlah'] as $obat_id => $jumlah) {
                if($obat_id!='resep'){
                    $rm_obat[$obat_id]['obat_id'] = $obat_id;
                    $rm_obat[$obat_id]['jumlah'] = $jumlah;
                    $d = Obat::findOne($obat_id);
                    $rm_obat[$obat_id]['nama_obat'] = $d['nama_merk'];
                    $rm_obat[$obat_id]['signa'] = $post_data['Obat']['signa'][$obat_id];
                }
            }

            if(isset($post_data['Obat']['jumlah']['resep'])){
                foreach($post_data['Obat']['jumlah']['resep'] as $key_resep=>$jumlah){
                    $rm_obat[$key_resep.'a']['obat_id'] = null;
                    $rm_obat[$key_resep.'a']['jumlah'] = $jumlah;
                    $rm_obat[$key_resep.'a']['nama_obat'] = $post_data['Obat']['nama']['resep'][$key_resep];
                    $rm_obat[$key_resep.'a']['signa'] = $post_data['Obat']['signa']['resep'][$key_resep];
                }
            } 
        }

        $rm_obatracik_komponen = [];
        $rm_obatracik = [];
        if(isset($post_data['ObatRacik']))
        foreach ($post_data['ObatRacik'] as $counter => $obatracik) {
            $rm_obatracik[$counter]['jumlah'] = $obatracik['jumlah_pulf'];
            $rm_obatracik[$counter]['signa'] = $obatracik['signa'];
            if(isset($obatracik['jumlah'])){
                if(isset($post_data['Obat']['jumlah']['resep'])){
                    foreach ($obatracik['jumlah'] as $obat_id => $jumlah) {
                        if($obat_id!='resep'){
                            $rm_obatracik_komponen[$counter][$obat_id]['obat_id'] = $obat_id;
                            $d = Obat::findOne($obat_id);
                            $rm_obatracik_komponen[$counter][$obat_id]['nama_obat'] = $d['nama_merk'];
                            $rm_obatracik_komponen[$counter][$obat_id]['jumlah'] = $jumlah;
                        }
                    }
                    if(isset($obatracik['jumlah']['resep']))
                    foreach($obatracik['jumlah']['resep'] as $key_resep=>$jumlah){
                        $rm_obatracik_komponen[$counter][$key_resep.'a']['obat_id'] = null;
                        $rm_obatracik_komponen[$counter][$key_resep.'a']['jumlah'] = $jumlah;
                        $rm_obatracik_komponen[$counter][$key_resep.'a']['nama_obat'] = $obatracik['nama']['resep'][$key_resep];
                    }
                } 
            }
        } 

        return compact('model','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','histori_rm');
    }

    private function saveDataRm($post_data,$berhasil,$model)
    {
        if(isset($post_data['diagnosis']))
            foreach ($post_data['diagnosis'] as $key => $value) {
                $RmDiagnosis = new RmDiagnosis();
                $d = Diagnosis::findOne($value);
                $RmDiagnosis->rm_id = $model->rm_id;
                if(empty($d)){
                    $RmDiagnosis->kode = null;
                    $RmDiagnosis->nama_diagnosis = $value;
                } else {
                    $RmDiagnosis->kode = $value;
                    $RmDiagnosis->nama_diagnosis = $d['nama'];
                }

                $berhasil = $berhasil && $RmDiagnosis->save();
            }
        
        if(isset($post_data['diagnosis_banding']))
            foreach ($post_data['diagnosis_banding'] as $key => $value) {
                $RmDiagnosis = new RmDiagnosisBanding();
                $d = Diagnosis::findOne($value);
                $RmDiagnosis->rm_id = $model->rm_id;
                if(empty($d)){
                    $RmDiagnosis->kode = null;
                    $RmDiagnosis->nama_diagnosis = $value;
                } else {
                    $RmDiagnosis->kode = $value;
                    $RmDiagnosis->nama_diagnosis = $d['nama'];
                }
                $berhasil = $berhasil && $RmDiagnosis->save();
            }

        /*
        $tindakan_wajib = Tindakan::findAll(['klinik_id'=>Yii::$app->user->identity->klinik_id,'biaya_wajib'=>1]);

        foreach ($tindakan_wajib as $value) {
            $RmTindakan = new RmTindakan();
            $RmTindakan->rm_id = $model->rm_id;
            $RmTindakan->tindakan_id = $value['tindakan_id'];
            $d = Tindakan::findOne($value);
            $RmTindakan->nama_tindakan = 'Umum';
            $berhasil = $berhasil && $RmTindakan->save();
        }*/

        if(isset($post_data['obatAnak']))
            foreach ($post_data['obatAnak']['obat'] as $key => $value) {
                $RmObatAnak = new RmObatAnak();
                $RmObatAnak->rm_id = $model->rm_id;
                $RmObatAnak->obat_id = $value;
                $RmObatAnak->dosis = $post_data['obatAnak']['dosis'][$key];
                $obtTemp = Obat::findOne($value);
                $RmObatAnak->nama_obat = "[{$obtTemp->golongan}] {$obtTemp->nama_merk}";
                $RmObatAnak->kemasan = $post_data['obatAnak']['kemasan'][$key];
                $RmObatAnak->jumlah = $post_data['obatAnak']['jumlah'][$key];

                $berhasil = $berhasil && $RmObatAnak->save();
            }

        if(isset($post_data['tindakan']))
            foreach ($post_data['tindakan'] as $key => $value) {
                $RmTindakan = new RmTindakan();
                $RmTindakan->rm_id = $model->rm_id;
                $RmTindakan->tindakan_id = $value;
                $d = Tindakan::findOne($value);
                $RmTindakan->nama_tindakan = $d['nama_tindakan'];
                $berhasil = $berhasil && $RmTindakan->save();
            }
        
        if(isset($post_data['Obat'])){
            foreach ($post_data['Obat']['jumlah'] as $obat_id => $jumlah) {
                if($obat_id!='resep'){
                    $RmObat = new RmObat();
                    $RmObat->rm_id = $model->rm_id;
                    $RmObat->obat_id = $obat_id;
                    $RmObat->jumlah = $jumlah;
                    $RmObat->signa = $post_data['Obat']['signa'][$obat_id];
                    $d = Obat::findOne($obat_id);
                    $RmObat->nama_obat = $d['nama_merk'];
                    $berhasil = $berhasil && $RmObat->save();
                }
            }
            if(isset($post_data['Obat']['jumlah']['resep']))
                foreach ($post_data['Obat']['jumlah']['resep'] as $resep_key => $jumlah) {
                    $RmObat = new RmObat();
                    $RmObat->rm_id = $model->rm_id;
                    $RmObat->obat_id = null;
                    $RmObat->jumlah = $jumlah;
                    $RmObat->signa = $post_data['Obat']['signa']['resep'][$resep_key];
                    $RmObat->nama_obat = $post_data['Obat']['nama']['resep'][$resep_key];
                    $berhasil = $berhasil && $RmObat->save();
                }
        }
            
        if(isset($post_data['ObatRacik']))
            foreach ($post_data['ObatRacik'] as $counter => $obatracik) {
                if(isset($obatracik['jumlah'])){
                    $RmObatRacik = new RmObatRacik();
                    $RmObatRacik->rm_id = $model->rm_id;
                    $RmObatRacik->jumlah = $obatracik['jumlah_pulf'];
                    $RmObatRacik->signa = $obatracik['signa'];
                    $berhasil = $berhasil && $RmObatRacik->save();

                    foreach ($obatracik['jumlah'] as $obat_id => $jumlah) {
                        if($obat_id!='resep'){
                            $RmObatRacikKomponen = new RmObatRacikKomponen();
                            $RmObatRacikKomponen->racik_id = $RmObatRacik->racik_id;
                            $RmObatRacikKomponen->obat_id = $obat_id;
                            $RmObatRacikKomponen->jumlah = $jumlah;
                            $d = Obat::findOne($obat_id);
                            $RmObatRacikKomponen->nama_obat = $d['nama_merk'];
                            $berhasil = $berhasil && $RmObatRacikKomponen->save();
                        }
                    }
                    if(isset($obatracik['jumlah']['resep']))
                        foreach ($obatracik['jumlah']['resep'] as $resep_key => $jumlah) {
                            $RmObatRacikKomponen = new RmObatRacikKomponen();
                            $RmObatRacikKomponen->racik_id = $RmObatRacik->racik_id;
                            $RmObatRacikKomponen->obat_id = null;
                            $RmObatRacikKomponen->jumlah = $jumlah;
                            $RmObatRacikKomponen->nama_obat = $obatracik['nama']['resep'][$resep_key];
                            $berhasil = $berhasil && $RmObatRacikKomponen->save();
                        }
                }
            }

        return $berhasil;
    }

    private function resetRmKomponen($id,$only_obat = false)
    {
        if(!$only_obat){
            RmDiagnosis::deleteAll(['rm_id'=>$id]);
            RmDiagnosisBanding::deleteAll(['rm_id'=>$id]);
            RmTindakan::deleteAll(['rm_id'=>$id]);
        }
        
        RmObatAnak::deleteAll(['rm_id'=>$id]);
        RmObat::deleteAll(['rm_id'=>$id]);
        $rm_obatracik = RmObatRacik::findAll(['rm_id'=>$id]);
        foreach ($rm_obatracik as $key => $value)
            RmObatRacikKomponen::deleteAll(['racik_id'=>$value['racik_id']]);
        RmObatRacik::deleteAll(['rm_id'=>$id]);
    }


    /**
     * Finds the RekamMedis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RekamMedis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RekamMedis::findOne($id)) !== null) {
            $model->decryptDulu();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPenunjang($id)
    {

        if (($model = RmPenunjang::findOne($id)) !== null) {
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

    protected function isUserAuthorCreate()
    {
        $kunjungan_id = Yii::$app->security->decryptByKey( utf8_decode(Yii::$app->request->get('kunjungan_id')), Yii::$app->params['kunciInggris'] );

        return $this->findModelKunjungan($kunjungan_id)->klinik_id == Yii::$app->user->identity->klinik_id;
    }

    protected function isUserAuthor()
    {   
        $id = Yii::$app->security->decryptByKey( utf8_decode(Yii::$app->request->get('id')), Yii::$app->params['kunciInggris'] );
        return $this->findModel($id)->user_id == Yii::$app->user->identity->id;
    }

    protected function isUserAuthorPenunjang($rm_id)
    {   
        return $this->findModel($rm_id)->user_id == Yii::$app->user->identity->id;
    }
    
    public function decryptUntilTrue($m)
    {
        if ( ($this->kedalaman<=3) &&base64_encode(base64_decode($m->pemeriksaan_fisik, true)) === $m->pemeriksaan_fisik)
        {
            try {
             $m->decryptDulu();
             $this->kedalaman++;
             $m = $this->decryptUntilTrue($m);
            }
            catch(Exception $e) {
                return $m;
              echo $m->id.'is error';
            }
        }
        return $m;
    }
    public $kedalaman = 0;
    
    // public function actionReverse()
    // {
    //     // if(isset($_GET['ids']))
    //     // {
    //     //     print_r(@$_GET['ids']);
    //     //     foreach ($_GET['ids'] as $id)
    //     //     {
    //     //         $m = RekamMedis::findOne($id);
    //     //         if($m->pemeriksaan_fisik!=''){
    //     //             // $m->decryptDulu();
                    
    //     //             // if ( base64_encode(base64_decode($m->pemeriksaan_fisik, true)) === $m->pemeriksaan_fisik)
    //     //             // {
    //     //             //     try {
    //     //             //      $m->decryptDulu();
    //     //             //      echo $m->pemeriksaan_fisik.'<br>';
    //     //             //     }
    //     //             //     catch(Exception $e) {
    //     //             //       echo $m->id.'is error';
    //     //             //     }
    //     //             // }
    //     //             $m = $this->decryptUntilTrue($m);
    //     //             echo $m->pemeriksaan_fisik.'<br>';
    //     //         }
    //     //     }
    //     //     die;
    //     // }
    //     $rm = RekamMedis::find()->limit(10000)->where(['user_id'=>282])->andwhere(['like','YEAR(created)',2017])->all();
    //     // echo '<form method="get">';

    //     foreach($rm as $r)
    //     {
    //         $this->kedalaman = 0;
    //         // $r = $this->decryptUntilTrue($r);
    //         // $r->save();
    //         $r->decryptDulu();
    //         echo '<input type="checkbox" name="ids[]" value="'.$r->rm_id.'">'.$r->created.' T'.$r->modified.'T '.$r->pemeriksaan_fisik.'<br>';
    //     }
    //     // echo '<input type="submit"></form>';
    // }

    //DOWNLOAD SURAT UNTUK OBGYN ID = 28
    public function actionSuratPengantarRujukan($id){
        if(Yii::$app->user->identity->spesialis != 28)
            throw new NotFoundHttpException('The requested page does not exist.');
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('_headerSurat',compact('model','klinik','dokter'));
        $content .= $this->renderPartial('suratPengantarRujukan',compact('model','klinik','dokter'));
        $content .= $this->renderPartial('_footerSurat',compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "Surat_pengantar_rujukan ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat_pengantar_rujukan ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionSuratKeteranganDiagnosis($id){
        if(Yii::$app->user->identity->spesialis != 28)
            throw new NotFoundHttpException('The requested page does not exist.');
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('_headerSurat',compact('model','klinik','dokter'));
        $content .= $this->renderPartial('suratKeteranganDiagnosis',compact('model','klinik','dokter'));
        $content .= $this->renderPartial('_footerSurat',compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "Surat_keterangan_diagnosis ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat_keterangan_diagnosis Sehat ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionSuratPernyataanMedis($id, $lang="eng"){
        if(Yii::$app->user->identity->spesialis != 28)
            throw new NotFoundHttpException('The requested page does not exist.');
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('suratPernyataanMedis/'.$lang,compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "Surat_pernyataan_medis ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Surat_pernyataan_medis ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionSuratLayakTerbang($id, $lang="eng"){
        if(Yii::$app->user->identity->spesialis != 28)
            throw new NotFoundHttpException('The requested page does not exist.');
        $id = Yii::$app->security->decryptByKey( utf8_decode($id), Yii::$app->params['kunciInggris'] );
        if(!$this->isUserAuthor()) 
            throw new NotFoundHttpException('The requested page does not exist.');

        $model = $this->findModel($id);
        $klinik = Klinik::findOne(Yii::$app->user->identity->klinik_id);
        $dokter = Dokter::findOne($model->user_id);

        $content = $this->renderPartial('suratLayakTerbang/'.$lang,compact('model','klinik','dokter'));
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'filename' => "Fit_to_travel ".$model->mr0->mr." ".$model->created.".pdf",
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => "Fit_to_travel ".$model->mr0->mr." ".$model->created],
             // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>["Surat Sehat, No.RM: ".$model->mr0->mr.", Tanggal Periksa:".$model->created], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
         ob_end_clean();
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionAutoCompleteS($q='')
    {
        if($q==''){
            echo json_encode([]);
        }
        else{
            $optionsAll = RekamMedis::find()->leftJoin('kunjungan','rekam_medis.kunjungan_id=kunjungan.kunjungan_id')->select('anamnesis')->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id])->andwhere(['<>','anamnesis',''])->all();
            $optionsFiltered = [];
            foreach ($optionsAll as $key => $value) {
                $value->decryptDulu();
                $s = strip_tags($value->anamnesis);
                if (strpos($s, $q) !== false && !in_array($s,$optionsFiltered))
                   $optionsFiltered[] = $s;
            }

            $autocomplete = new AutoComplete($q,$optionsFiltered);
            $autocomplete->calculate();
            // echo json_encode(array_column($autocomplete->output, 'string'));
            echo json_encode($autocomplete->output);
        }
    }

    public function actionAutoCompleteO($q='')
    {
        if($q==''){
            echo json_encode([]);
        }
        else{
            $optionsAll = RekamMedis::find()->leftJoin('kunjungan','rekam_medis.kunjungan_id=kunjungan.kunjungan_id')->select('pemeriksaan_fisik')->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id])->andwhere(['<>','pemeriksaan_fisik',''])->all();
            $optionsFiltered = [];
            foreach ($optionsAll as $key => $value) {
                $value->decryptDulu();
                $s = strip_tags($value->pemeriksaan_fisik);
                if (strpos($s, $q) !== false && !in_array($s,$optionsFiltered))
                   $optionsFiltered[] = $s;
            }
            $autocomplete = new AutoComplete($q,$optionsFiltered);
            $autocomplete->calculate();
            echo json_encode(array_column($autocomplete->output, 'string'));
        }
    }
    public function actionAutoCompleteA($q='')
    {
        if($q==''){
            echo json_encode([]);
        }
        else{
            $optionsAll = RekamMedis::find()->leftJoin('kunjungan','rekam_medis.kunjungan_id=kunjungan.kunjungan_id')->select('assesment')->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id])->andwhere(['<>','assesment',''])->all();
            $optionsFiltered = [];
            foreach ($optionsAll as $key => $value) {
                $value->decryptDulu();
                $s = strip_tags($value->assesment);
                if (strpos($s, $q) !== false && !in_array($s,$optionsFiltered))
                   $optionsFiltered[] = $s;
            }

            $autocomplete = new AutoComplete($q,$optionsFiltered);
            $autocomplete->calculate();
            echo json_encode(array_column($autocomplete->output, 'string'));
        }
    }
    public function actionAutoCompleteP($q='')
    {
        if($q==''){
            echo json_encode([]);
        }
        else{
            $optionsAll = RekamMedis::find()->leftJoin('kunjungan','rekam_medis.kunjungan_id=kunjungan.kunjungan_id')->select('plan')->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id])->andwhere(['<>','plan',''])->all();
            $optionsFiltered = [];
            foreach ($optionsAll as $key => $value) {
                $value->decryptDulu();
                $s = strip_tags($value->plan);
                if (strpos($s, $q) !== false && !in_array($s,$optionsFiltered))
                   $optionsFiltered[] = $s;
            }

            $autocomplete = new AutoComplete($q,$optionsFiltered);
            $autocomplete->calculate();
            echo json_encode(array_column($autocomplete->output, 'string'));
        }
    }

    public function actionRmGanda()
    {

        if(count($_POST)){
            $hapus = $_POST['rm_id'];
            foreach ($hapus as $key => $value) {
                RekamMedis::findOne($value)->delRelationship();
            }
            return $this->redirect(['rekam-medis/rm-ganda']);
        }
        $m = RekamMedis::find()->groupBy(['kunjungan_id'])->select('kunjungan_id')->having(['>','count(kunjungan_id)',1])->asArray()->all();
        $dobel = array_column($m, 'kunjungan_id');


                echo "<style>#myBtn {
          position: fixed;
          bottom: 20px;
          right: 30px;
          z-index: 99;
          font-size: 18px;
          border: none;
          outline: none;
          background-color: red;
          color: white;
          cursor: pointer;
          padding: 15px;
          border-radius: 4px;
        }</style>";
        
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
        echo '<input type="submit" id="myBtn" title="Hapus" value="Hapus terpiilh">';
        foreach ($dobel as $key => $value) {
            $model = RekamMedis::find()->where(['kunjungan_id'=>$value])->all();
            echo   "<table border='1'>";
            foreach ($model as $key2 => $value2) {
                $value2->decryptDulu();
                echo   "<tr>
                            <td><input type='checkbox' name='rm_id[]' value='".$value2->rm_id."'></td>
                            <td><pre>".print_r($value2->attributes,true)."</pre></td>
                            <td><pre>".print_r($value2->rmDiagnoses,true)."</pre></td>
                            <td><pre>".print_r($value2->rmDiagnosisBandings,true)."</pre></td>
                            <td><pre>".print_r($value2->rmObats,true)."</pre></td>
                            <td><pre>".print_r($value2->rmObatAnaks,true)."</pre></td>
                            <td><pre>".print_r($value2->rmObatRaciks,true)."</pre></td>
                            <td><pre>".print_r($value2->rmTindakans,true)."</pre></td>
                        </tr>";
            }
            echo "</table><br>";
        }
        ActiveForm::end();
    }
}
