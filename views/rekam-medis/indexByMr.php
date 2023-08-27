<?php
use app\models\Dokter;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RekamMedis */

$this->title = 'Riwayat Rekam Medis';
$this->params['breadcrumbs'][] = ['label' => 'Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Riwayat';
?>
<style type="text/css">
	.profile-stat-text {
	    color: #5b9bd1;
	    font-size: 11px;
	    font-weight: 800;
	    text-align: center;
	}
	.profile-stat-title {
	    color: #7f90a4;
	    font-size: 25px;
	    text-align: center;
	}
</style>
<div class="portlet-body form">
	<table class="table table-bordered" style="width: 50%">
		<tr>
			<td width="30%">No. Rekam Medis</td>
			<td><?= Html::encode($pasien->mr) ?></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td><?= Html::encode($pasien->nama) ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><?= Html::encode($pasien->alamat) ?></td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td><?= Html::encode($pasien->jk) ?></td>
		</tr>
		<tr>
			<td>Umur</td>
			<td><?= $pasien->getAge($pasien->tanggal_lahir) ?> Tahun</td>
		</tr>
		<tr>
			<td>Riwayat Alergi</td>
			<td><?= preg_replace('#<script(.*?)>(.*?)</script>#is', '', $pasien->alergi) ?></td>
		</tr>
	</table>
</div>
<div class="row">
	<div class="portlet light portlet-fit ">
		<div class="portlet-title">
		</div>
		<div class="portlet-body">
			<div class="timeline">
				<?php foreach ($rm as $key => $value){ 
					$value->decryptDulu();?>
					<!-- TIMELINE ITEM -->
					<div class="timeline-item">
						<div class="timeline-badge">
							<div class="timeline-icon">
								<i class="icon-docs font-red-intense"></i>
							</div>
						</div>
						<div class="timeline-body">
							<div class="timeline-body-arrow"> </div>
							<div class="timeline-body-head">
								<div class="timeline-body-head-caption">
									<span class="timeline-body-alerttitle font-green-haze"><?= date('d F Y', strtotime($value->created)) ?></span>
								</div>
							</div>
							<div class="timeline-body-content">
								<table class="table">
									<tr>
										<td width="60%">
											<table class="table table-bordered table-hover">
												<tr>
													<td width="30%">
														Keluhan Utama
													</td>
													<td>
														<?= $value->keluhan_utama ?>
													</td>
												</tr>
												<tr>
													<td>
														(S) Subyektif
													</td>
													<td>
														<?= $value->anamnesis ?>
													</td>
												</tr>
												<tr>
													<td>
														(O) Obyektif
													</td>
													<td>
														<?= $value->pemeriksaan_fisik ?>
													</td>
												</tr>
												<tr>
													<td>
														(A) Assesment
													</td>
													<td>
														<?= $value->assesment ?>
													</td>
												</tr>
												<tr>
													<td>
														(P) Plan
													</td>
													<td>
														<?= $value->plan ?>
													</td>
												</tr>
											</table>
										</td>
										<td>
											<div class="portlet light bordered">
								                <!-- STAT -->
								                <div class="row list-separated profile-stat">
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->tekanan_darah ?> </div>
								                        <div class="uppercase profile-stat-text"> TD (120/80) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->nadi ?> </div>
								                        <div class="uppercase profile-stat-text"> Nadi (x/min) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->respirasi_rate ?> </div>
								                        <div class="uppercase profile-stat-text"> Resp Rate (x/min) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->suhu ?> </div>
								                        <div class="uppercase profile-stat-text"> Suhu (C) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->berat_badan ?>  </div>
								                        <div class="uppercase profile-stat-text"> BB (kg) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= $value->tinggi_badan ?> </div>
								                        <div class="uppercase profile-stat-text"> TB (cm) </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6"></div>
								                    <div class="col-md-4 col-sm-4 col-xs-6">
								                        <div class="uppercase profile-stat-title"> <?= number_format($value->bmi,2,',','') ?> </div>
								                        <div class="uppercase profile-stat-text"> BMI </div>
								                    </div>
								                    <div class="col-md-4 col-sm-4 col-xs-6"></div>
								                    
								                </div>
								                <!-- END STAT -->
								            </div>
								        </td>
									</tr>
									<tr>
										<td colspan="2">
											<table class="table table-bordered table-hover">
												<tr>
													<td colspan="3" class="text-center"><h4>Detail Pemeriksaan</h4></td>
												</tr>
												<tr>
													<td width="30%">
														Diagnosis 1 (ICD-10)
													</td>
													<td colspan="2">
														<ul>
				                                            <?php foreach($value->rmDiagnoses as $value2): ?>
				                                                <li><?= !empty($value2['kode']) ? $value2['kode']." - ".$value2['nama_diagnosis'] : $value2['nama_diagnosis'] ?></li>
				                                            <?php endforeach; ?>
			                                            </ul>
													</td>
												</tr>
												<tr>
													<td>
														Diagnosis 2 (ICD-10)
													</td>
													<td colspan="2">
														<ul>
				                                            <?php foreach($value->rmDiagnosisBandings as $value2): ?>
				                                                <li><?= !empty($value2['kode']) ? $value2['kode']." - ".$value2['nama_diagnosis'] : $value2['nama_diagnosis'] ?></li>
				                                            <?php endforeach; ?>
			                                            </ul>
													</td>
												</tr>
												<tr>
													<td>
														Tindakan
													</td>
													<td colspan="2">
														<ul>
															<?php foreach($value->rmTindakans as $value2): ?>
                                                				<li><?= $value2['nama_tindakan'] ?></li>
                                            				<?php endforeach; ?>
                                        				</ul>
													</td>
												</tr>
												<!-- DAFTAR OBAT -->
												<tr>
													<td colspan="3" class="text-center"><h4>Detail Pemberian Obat</h4></td>
												</tr>
												<tr>
													<td><strong>Nama Obat</strong></td>
													<td><strong>Jumlah</strong></td>
													<td><strong>Signa</strong></td>
												</tr>
												<?php foreach($value->rmObats as $value2): ?>
                                                    <tr>
                                                        <td><?= Html::encode($value2->nama_obat) ?></td>
                                                        <td><?= $value2->jumlah ?></td>
                                                        <td><?= Html::encode($value2->signa) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <!-- DAFTAR OBAT RACIK -->
                                                <tr>
													<td colspan="3" class="text-center"><h4>Detail Pemberian Obat Racik</h4></td>
												</tr>
												<tr>
													<td colspan="2"><strong>Signa</strong></td>
													<td><strong>Jumlah</strong></td>
												</tr>
												<?php foreach($value->rmObatRaciks as $value2): ?>
                                                    <tr>
                                                        <td colspan="2"><?= Html::encode($value2->signa) ?></td>
                                                        <td><?= $value2->jumlah ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <!-- OBAT RACIK ANAK -->
                                                <?php if (Dokter::findOne(Yii::$app->user->identity->id)->spesialis==3){ ?>
                                                	<tr>
														<td colspan="3" class="text-center"><h4>Detail Pemberian Resep Obat Anak</h4></td>
													</tr>
													<tr>
                                                        <td><strong>Nama Obat</strong></td>
                                                        <td><strong>Dosis</strong></td>
                                                        <td><strong>Jumlah<</strong>/td>
                                                    </tr>
                                                	<?php foreach($value->rmObatAnaks as $value2)
                                                	{ ?>
                                                		<tr>
                                                            <td><?= Html::encode($value2->nama_obat) ?></td>
                                                            <td><?= Html::encode($value2->dosis) ?></td>
                                                            <td><?= Html::encode($value2->jumlah) ?> <?= Html::encode($value2->kemasan) ?></td>
                                                        </tr>
                                                <?php
                                                	} 
                                            	} ?>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<!-- END TIMELINE ITEM -->
				<?php } ?>
			</div>
		</div>
	</div>
</div>