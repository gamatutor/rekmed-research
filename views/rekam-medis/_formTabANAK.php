<?php 
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Tindakan;
use yii\helpers\Html;
$form = ActiveForm::begin(['id'=>'form-rm']); ?>

<style>
.tooltipp {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltipp .tooltiptextt {
    visibility: hidden;
    width: 500%;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px !important;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: -5px;
    left: 110%;
}

.tooltipp .tooltiptextt::after {
    content: "";
    position: absolute;
    top: 50%;
    right: 100%;
    margin-top: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent black transparent transparent;
}
.tooltipp:hover .tooltiptextt {
    visibility: visible;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase">Detail Alergi</span>
                </div>
            </div>
            <div class="portlet-body form">
                <?= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $model->mr0->alergi); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase">REKAM MEDIS</span>
                </div>
            </div>
            <div>
                <input type="checkbox" class="form-control" id="adv" name="adv"> 
                <label for="adv" style="cursor: help;" class="tooltipp">ICD-10 dan farmasi
                    <span class="tooltiptextt">BPJS untuk rekam medis lengkap. Seperti ICD-10, Kasir, dan apotek/farmasi</span>
                </label>
            </div>
            <br/>
            <div class="portlet-body form">
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab"> PENGECEKAN </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab"> PEMERIKSAAN </a>
                    </li>
                    <li>
                        <a href="#tab_5" class="more_adv" data-toggle="tab"> PEMERIKSAAN LANJUT </a>
                    </li>
                    <li>
                        <a href="#tab_3" class="more_adv" data-toggle="tab"> OBAT </a>
                    </li>
                    <li>
                        <a href="#tab_4" class="more_adv" data-toggle="tab"> OBAT RACIK </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_1">
                        <label><input type='checkbox' id='useDefault' value="1">Nilai Normal</label>
                        <div class="row">
                            <div class="col-md-4"><?= $form->field($model, 'tekanan_darah')->textInput(['class'=>'tekanan_darah form-control','maxlength' => true]) ?></div>
                            <div class="col-md-4"><?= $form->field($model, 'nadi')->textInput(['class'=>'nadi  form-control']) ?></div>
                            <div class="col-md-4"><?= $form->field($model, 'respirasi_rate')->textInput(['class'=>'respirasi_rate form-control']) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><?= $form->field($model, 'suhu')->textInput(['class'=>'suhu form-control']) ?></div>
                            <div class="col-md-4"><?= $form->field($model, 'berat_badan')->textInput() ?></div>
                            <div class="col-md-4"><?= $form->field($model, 'tinggi_badan')->textInput() ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="rekammedis-bmi">BMI</label>
                            <label class="control-label" id="bmi_hasil"></label>
                        </div>
                        <div class="form-group">
                            <label>Daftar Alergi Obat (jika ada)</label>
                            <?= \yii\redactor\widgets\Redactor::widget([
                                    'model' => $model->mr0,
                                    'attribute' => 'alergi',
                                    'clientOptions'=>[
                                        'buttons' => []
                                    ]
                                ]) ?>
                            <?= Html::button('<i class="fa fa-plus"></i> Input Tanggal', ['class' => 'btn green-haze btn-outline sbold uppercase inputTglbaru']) ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keluhan Utama</label>
                            <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'keluhan_utama',
                                'clientOptions'=>[
                                    'buttons' => []
                                ]
                            ]) ?>
                        </div>
                        <?php echo Html::submitButton('Simpan & lanjut ke PEMERIKSAAN', ['id'=>'simpan_submit','class' => 'btn red','name'=>'SimpanNext', 'value'=>'tab_2']) ?>
                    </div>
                    <div class="tab-pane fade" id="tab_2">

                        <div class="form-group">
                            <?php
                                $url = \yii\helpers\Url::toRoute(['template-soap/load-template']);
                                echo $form->field($model, 'loadTemplate')->widget(Select2::classname(), [
                                          'options' => ['placeholder' => 'Pilih'],
                                    'pluginOptions' => [
                                        'maximumInputLength' => 100,
                                        'allowClear' => true,
                                        'minimumInputLength' => 2,
                                        'ajax' => [
                                            'url' => $url,
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                        'templateSelection' => new JsExpression('function(city) { 
                                                if (typeof city.S !== "undefined") {
                                                    // $("#rekammedis-anamnesis").redactor("code.set", city.S);
                                                    // $("#rekammedis-pemeriksaan_fisik").redactor("code.set", city.O);
                                                    // $("#rekammedis-assesment").redactor("code.set", city.A);
                                                    // $("#rekammedis-plan").redactor("code.set", city.P);
                                                    $("#rekammedis-anamnesis").val(city.S);
                                                    $("#rekammedis-pemeriksaan_fisik").val(city.O);
                                                    $("#rekammedis-assesment").val(city.A);
                                                    $("#rekammedis-plan").val(city.P);
                                                }
                                                return city.text; 
                                        }'),//after
                                    ],
                                ]);
                                ?>
                        </div>



                        <div class="form-group">
                            <label class="control-label">S (Subyekif)</label>
                            <?php 
                                // echo \yii\redactor\widgets\Redactor::widget([
                                // 'model' => $model,
                                // 'attribute' => 'anamnesis',
                                // 'clientOptions'=>[
                                //     'buttons' => []
                                // ]
                                // ]) 
                            ?>
                            <?php echo $form->field($model, 'anamnesis')->textInput()->label(false); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">O (Obyektif)</label>
                            <?php 
                                // echo \yii\redactor\widgets\Redactor::widget([
                                // 'model' => $model,
                                // 'attribute' => 'pemeriksaan_fisik',
                                // 'clientOptions'=>[
                                //     'buttons' => []
                                // ]
                                // ]) 
                            ?>
                            <?php echo $form->field($model, 'pemeriksaan_fisik')->textInput()->label(false); ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">A (Assesment)</label>
                            <?php 
                                // echo \yii\redactor\widgets\Redactor::widget([
                                // 'model' => $model,
                                // 'attribute' => 'assesment',
                                // 'clientOptions'=>[
                                //     'buttons' => []
                                // ]
                                // ]) 
                            ?>
                            <?php echo $form->field($model, 'assesment')->textInput()->label(false); ?>
                        </div>

                        <div class="row">
                            <?php $delBtnObatAnak = Html::button('<i class="fa fa-trash"></i> Hapus', ['class' => 'btn red-mint btn-outline sbold uppercase hapusObatAnak']);?>
                            <table id="listTindakan" class="table table-striped table-hover">
                                <thead>
                                    <th>Obat</th>
                                    <th>Dosis (mg/kgbb)</th>
                                    <th>Kemasan (mg/tablet)</th>
                                    <th>Jumlah</th>
                                    <th>Tb. yang dipuyer</th>
                                    <th>Aksi</th>
                                </thead>
                                <thead>
                                    <th>
                                        <?= Select2::widget([
                                            'name' => 'obat_anak',
                                            'options' => ['placeholder' => 'Pilih Obat'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression("function () { return 'Mencari...'; }"),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['obat/cari']),
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(dat) { return dat.text; }'),
                                                'templateSelection' => new JsExpression('function (dat) { $(".dosis_obat_anak").val(dat.dosis); $(".kemasans_obat_anak").val(dat.kemasan); return dat.text; }'),
                                            ],
                                        ]) ?>
                                    </th>
                                    <th>
                                        <?= Html::textInput('dosis_anak','',['class'=>'form-control dosis_obat_anak'])?>
                                    </th>
                                    <th>
                                        <?= Html::textInput('kemasan_anak','',['class'=>'form-control kemasans_obat_anak', 'list'=>"kemasanOption"])?>
                                            <datalist id="kemasanOption">
                                                
                                            </datalist>
                                    </th>
                                    <th>
                                        <?= Html::textInput('obat_anak','',['class'=>'form-control jumlah_obat_anak'])?>
                                    </th>
                                    <th></th>
                                    <th><?= Html::button('<i class="fa fa-plus"></i> Tambah', ['class' => 'addObatAnak btn green-haze btn-outline sbold uppercase']) ?></th>
                                </thead>
                                <tbody>

                                    <?php if(!$model->isNewRecord)
                                                foreach ($model->rmObatAnaks as $key => $value):?>
                                                    <tr><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[obat][]" value="<?= Html::encode($value->obat_id) ?>"><?= Html::encode($value->nama_obat) ?></td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[dosis][]" value="<?= Html::encode($value->dosis) ?>"><?= Html::encode($value->dosis) ?></td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[kemasan][]" value="<?= Html::encode($value->kemasan) ?>"><?= Html::encode($value->kemasan) ?></td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[jumlah][]" value="<?= Html::encode($value->jumlah)?>"><?=Html::encode( $value->jumlah) ?></td><td><?= @number_format((($value->dosis*$model->berat_badan*$value->jumlah)/$value->kemasan),2)?></td><td><?= $delBtnObatAnak?></td></tr>
                                    <?php endforeach; ?>
                                   
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="control-label">P (Plan)</label>
                            <?php
                            //     echo \yii\redactor\widgets\Redactor::widget([
                            //     'model' => $model,
                            //     'attribute' => 'plan',
                            //     'clientOptions'=>[
                            //         'buttons' => []
                            //     ]
                            // ]) 
                            ?>

                            <?= $form->field($model, 'plan')->textInput()->label(false); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'addToTemplate')->checkbox(['class'=>'addToTemplate']); ?>
                            </div>
                            <div class="col-md-9 templateName" style="display: none">
                                <?= $form->field($model, 'templateName')->textInput(); ?>
                            </div>
                        </div>
                        <?php echo Html::submitButton('Simpan & Selesai Periksa', ['id'=>'selesai_submit','class' => 'btn blue','name'=>'Selesai']) ?>
                        <?php echo Html::submitButton('Simpan & lanjut ke PEMERIKSAAN LANJUT', ['id'=>'simpan_submit','class' => 'btn red','name'=>'SimpanNext', 'value'=>'tab_5']) ?>
                    </div>
                    <div class="more_adv tab-pane fade" id="tab_5">
                        <div class="form-group">
                            <?php

                            echo '<label class="control-label">Diagnosis (ICD-10)</label>';
                            echo Select2::widget([
                                'name' => 'diagnosis',
                                'options' => ['placeholder' => 'Pilih Diagnosis', 'multiple' => true],
                                'initValueText' => isset($rm_diagnosis_text) ? $rm_diagnosis_text : [],
                                'value' => isset($rm_diagnosis_id) ? $rm_diagnosis_id : [],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Mencari...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['diagnosis/cari']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(dat) { return dat.text; }'),
                                    'templateSelection' => new JsExpression('function (dat) { return dat.text; }'),
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            echo '<label class="control-label">Diagnosis 2 (ICD-10)</label>';
                            echo Select2::widget([
                                'name' => 'diagnosis_banding',
                                'options' => ['placeholder' => 'Pilih Diagnosis Banding', 'multiple' => true],
                                'initValueText' => isset($rm_diagnosis_banding_text) ? $rm_diagnosis_banding_text : [],
                                'value' => isset($rm_diagnosis_banding_id) ? $rm_diagnosis_banding_id : [],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Mencari...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['diagnosis/cari']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(dat) { return dat.text; }'),
                                    'templateSelection' => new JsExpression('function (dat) { return dat.text; }'),
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php

                            echo '<label class="control-label">Tindakan</label>';
                            echo Select2::widget([
                                'name' => 'tindakan',
                                'value' => isset($rm_tindakan) ? $rm_tindakan : [],
                                'data' => ArrayHelper::map(Tindakan::find()->where(['klinik_id'=>Yii::$app->user->identity->klinik_id,'biaya_wajib'=>0])->all(), 'tindakan_id', 'nama_tindakan'),
                                'options' => ['placeholder' => 'Pilih Tindakan', 'multiple' => true],
                                
                            ]);
                            ?>
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label">Deskripsi Tindakan</label>
                            <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'deskripsi_tindakan',
                                'clientOptions'=>[
                                    'buttons' => []
                                ]
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Hasil Penunjang</label>
                            <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'hasil_penunjang',
                                'clientOptions'=>[
                                    'buttons' => []
                                ]
                            ]) ?>
                        </div>
                        
                        

                        <div class="form-group">
                            <label class="control-label">Saran Pemeriksaan</label>
                            <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'saran_pemeriksaan',
                                'clientOptions'=>[
                                    'buttons' => []
                                ]
                            ]) ?>
                        </div> -->
                        <?php echo Html::submitButton('Simpan & Selesai Periksa', ['id'=>'selesai_submit','class' => 'btn blue','name'=>'Selesai']) ?>
                        <?php echo Html::submitButton('Simpan & lanjut ke OBAT', ['id'=>'simpan_submit','class' => 'btn red','name'=>'SimpanNext', 'value'=>'tab_3']) ?>
                    </div>
                    <div class="more_adv tab-pane fade" id="tab_3">

                        <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'biasa']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']) ?>
                        <?= Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','id'=>'tambah-resep','class' => 'btn green-haze btn-outline sbold uppercase']) ?>
                        
                        <br/>
                        <br/>
                        <table class="table table-hover table-light">
                            <thead>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Sinna</th>
                            </thead>
                            <tbody id="obat-rm">
                                <?php if(isset($data_exist['Obat'])): ?>
                                <?php foreach($data_exist['Obat']['jumlah'] as $obat_id => $jumlah): ?>
                                    <?php if($obat_id!='resep'): ?>
                                    <?php $obat = Obat::findOne(['obat_id'=>$obat_id]); ?> 
                                    <tr>
                                        <td><?= Html::encode($obat['nama_merk'])  ?></td>
                                        <td><input type="number" value="<?= Html::encode($jumlah) ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][<?= Html::encode($obat_id) ?>]"></td>
                                        <td><input type="text" value="<?= Html::encode($data_exist['Obat']['signa'][$obat_id]) ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][<?= Html::encode($obat_id) ?>]"></td>
                                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if(isset($rm_obat)): ?>
                                <?php foreach($rm_obat as $key => $value): ?>
                                    <?php if(!empty($value['obat_id'])): ?>
                                    <tr>
                                        <td><?= Html::encode($value['nama_obat'])  ?></td>
                                        <td><input type="number" value="<?= Html::encode($value['jumlah']) ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][<?= Html::encode($value['obat_id']) ?>]"></td>
                                        <td><input type="text" value="<?= $value['signa'] ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][<?= $value['obat_id'] ?>]"></td>
                                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                    </tr>
                                    <?php else: ?>
                                    <tr>
                                        <td><input value="<?= $value['nama_obat'] ?>" type="text" class="form-control" required="" placeholder="Nama" name="Obat[nama][resep][]"></td>
                                        <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][resep][]"></td>
                                        <td><input type="text" value="<?= $value['signa'] ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][resep][]"></td>
                                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php echo Html::submitButton('Simpan & Selesai Periksa', ['id'=>'selesai_submit','class' => 'btn blue','name'=>'Selesai']) ?>
                        <?php echo Html::submitButton('Simpan & lanjut ke OBAT RACIK', ['id'=>'simpan_submit','class' => 'btn red','name'=>'SimpanNext', 'value'=>'tab_4']) ?>
                    </div>
                    <div class="more_adv tab-pane fade" id="tab_4">
                        <div id="rightCol">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">Obat Racik</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']) ?>
                                    <?= Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class' => 'btn green-haze btn-outline sbold uppercase tambah-resep-racik','counter'=>1]) ?>
                                    <input type="hidden" value="1" />
                                    <?= Html::button('<i class="fa fa-plus"></i> Racikan', ['class' => 'btn purple-sharp btn-outline sbold uppercase tambahRacikan']) ?>
                                    
                                    <br/>
                                    <br/>
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                        </thead>
                                        <tbody id="obat-rm-racik-1">
                                            <?php if(isset($rm_obatracik[0])): ?>
                                            <?php if(isset($rm_obatracik_komponen[$rm_obatracik[0]['racik_id']])): ?>
                                            <?php foreach($rm_obatracik_komponen[$rm_obatracik[0]['racik_id']] as $key => $value): ?>
                                                <?php if(!empty($value['obat_id'])): ?>
                                                <tr>
                                                    <td><?= Html::encode($value['nama_obat'])  ?></td>
                                                    <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[1][jumlah][<?= Html::encode($value['obat_id']) ?>]"></td>
                                                    <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                                </tr>
                                                <?php else: ?>
                                                <tr>
                                                    <td><input value="<?= Html::encode($value['nama_obat']) ?>" type="text" class="form-control" required="" placeholder="Nama" name="ObatRacik[1][nama][resep][]"></td>
                                                    <td><input type="number" value="<?= Html::encode($value['jumlah']) ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[1][jumlah][resep][]"></td>
                                                    <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </tbody>

                                    </table>

                                    <div class="form-group">
                                        <label class="control-label" for="pulf">M.F.Pulv No.</label>
                                        <input type="number" name="ObatRacik[1][jumlah_pulf]" value="<?= isset($rm_obatracik[0]['jumlah']) ? Html::encode($rm_obatracik[0]['jumlah']) : "" ?>" id="pulf" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="signa_pulf">Signa</label>
                                        <input type="text" name="ObatRacik[1][signa]" value="<?= isset($rm_obatracik[0]['signa']) ? Html::encode($rm_obatracik[0]['signa']) : "" ?>" id="signa_pulf" class="form-control">
                                    </div>
                                    
                                </div>
                            </div>

                            <?php if(isset($rm_obatracik)): ?>
                            <?php if(count($rm_obatracik)>1): ?>
                            <?php foreach($rm_obatracik as $key_racik=>$value_racik): ?>
                            <?php if($key_racik==0) continue; ?>
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase">Obat Racik</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']).' '.Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class'=>'btn green-haze btn-outline sbold uppercase tambah-resep-racik','counter'=>$key_racik+2]) ?>
                                        <input type="hidden" value="1" />
                                        <?= Html::button('<i class="fa fa-trash"></i> Hapus Racikan', ['class' => 'btn red-mint btn-outline sbold uppercase hapusRacikan']) ?>
                                        
                                        <br/>
                                        <br/>
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <th>Nama Obat</th>
                                                <th>Jumlah</th>
                                            </thead>
                                            <tbody id="obat-rm-racik-1">
                                                <?php if(isset($rm_obatracik_komponen[$value_racik['racik_id']])): ?>
                                                <?php foreach($rm_obatracik_komponen[$value_racik['racik_id']] as $key => $value): ?>
                                                    <?php if(!empty($value['obat_id'])): ?>
                                                    <tr>
                                                        <td><?= Html::encode($value['nama_obat'])  ?></td>
                                                        <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[<?= $key_racik+2 ?>][jumlah][<?= $value['obat_id'] ?>]"></td>
                                                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                                    </tr>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td><input value="<?= Html::encode($value['nama_obat']) ?>" type="text" class="form-control" required="" placeholder="Nama" name="ObatRacik[<?= $key_racik+2 ?>][nama][resep][]"></td>
                                                        <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[<?= $key_racik+2 ?>][jumlah][resep][]"></td>
                                                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>

                                        </table>

                                        <div class="form-group">
                                            <label class="control-label" for="pulf">M.F.Pulv No.</label>
                                            <input type="number" name="ObatRacik[<?= $key_racik+2 ?>][jumlah_pulf]" value="<?= isset($value_racik['jumlah']) ? $value_racik['jumlah'] : "" ?>" id="pulf" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="signa_pulf">Signa</label>
                                            <input type="text" name="ObatRacik[<?= $key_racik+2 ?>][signa]" value="<?= isset($value_racik['signa']) ? $value_racik['signa'] : "" ?>" id="signa_pulf" class="form-control">
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php echo Html::submitButton('Simpan & Selesai Periksa', ['id'=>'selesai_submit','class' => 'btn blue','name'=>'Selesai']) ?>
                    </div>
                </div>
                <?php // echo Html::submitButton('Simpan', ['id'=>'simpan_submit','class' => 'btn blue','name'=>'Simpan']) ?>
                <?php // echo Html::submitButton('Simpan & Selesai Periksa', ['id'=>'selesai_submit','class' => 'btn red','name'=>'Selesai']) ?>
            </div>
        </div>
    </div>
    
</div>
<?php ActiveForm::end(); ?>

<?php 
$kemasanOptionAnakUrl = Url::to(['obat/kemasan-anak']);
$this->registerjs( 
<<< JS
        $('#kemasanOption').load('{$kemasanOptionAnakUrl}');

        $('.hapusObatAnak').click(function(){
                    var x = $(this).closest('tr').children('td.colObatAnak').find('.t').val();
                    $(this).closest('tr').remove();
                });

        $('.addObatAnak').click(function(){
            var s2Obat = $('#w0').select2('data');
            var dosis = $('.dosis_obat_anak').val();
            var kemasan = $('.kemasans_obat_anak').val();
            var jumlah = $('.jumlah_obat_anak').val();
            var jlhTbltPuyer = ((parseFloat(dosis) * parseFloat($('#rekammedis-berat_badan').val()) * parseFloat(jumlah))/parseFloat(kemasan)).toFixed(2);


            if($('#rekammedis-berat_badan').val()=="")
            {
                alert('Lengkapi Form Berat Badan dahulu...');
                return false;
            }

            if (s2Obat[0].id=='' || dosis=='' || kemasan=='' || jumlah==''){
                alert('Lengkapi Form Terlebih dahulu...');

            } else{
                var row = '<tr><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[obat][]" value="'+s2Obat[0].id+'">'+s2Obat[0].text+'</td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[dosis][]" value="'+dosis+'">'+dosis+'</td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[kemasan][]" value="'+kemasan+'">'+kemasan+'</td><td class="colObatAnak"><input class="t" type="hidden" name="obatAnak[jumlah][]" value="'+jumlah+'">'+jumlah+'</td><td>'+jlhTbltPuyer+'</td><td>{$delBtnObatAnak}</td></tr>';
                $('#listTindakan').append(row);

                $("#w0").select2("val", "");
                $('.dosis_obat_anak').val('');
                $('.kemasans_obat_anak').val('');
                $('.jumlah_obat_anak').val('');

                $('.hapusObatAnak').click(function(){
                    var x = $(this).closest('tr').children('td.colObatAnak').find('.t').val();
                    $(this).closest('tr').remove();
                });
            }
        })
JS
,4); ?>

<?php
    $this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/autocomplete-master/jquery.autocomplete.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerCssFile(Yii::$app->request->baseUrl.'/plugins/autocomplete-master/jquery.autocomplete.css');

    $this->registerJs('
         $("#rekammedis-anamnesis").autocomplete({
            source:[{
                url:"'.Url::to(['rekam-medis/auto-complete-s']).'?q=%QUERY%",
                type:"remote"
             }]
          }); 

         // $("#rekammedis-pemeriksaan_fisik").autocomplete({
         //    source:[{
         //        url:"'.Url::to(['rekam-medis/auto-complete-o']).'?q=%QUERY%",
         //        type:"remote"
         //     }]
         //  }); 

         $("#rekammedis-assesment").autocomplete({
            source:[{
                url:"'.Url::to(['rekam-medis/auto-complete-a']).'?q=%QUERY%",
                type:"remote"
             }]
          }); 

         $("#rekammedis-plan").autocomplete({
            source:[{
                url:"'.Url::to(['rekam-medis/auto-complete-p']).'?q=%QUERY%",
                type:"remote"
             }]
          }); 


        ');
?>