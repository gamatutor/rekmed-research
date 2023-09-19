<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
$this->title = 'Upload Penunjang';
$this->params['breadcrumbs'][] = ['label' => 'Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo \kato\DropZone::widget([
       'options' => [
       	   'url' => Url::to(['rekam-medis/upload','id'=>$id]),
           'maxFilesize' => '2',
           'addRemoveLinks'=> true,
       ],
       'clientEvents' => [
           // 'complete' => new JsExpression("function(file,response){
           //    alert(response);
           // }"),
           'error'=> new JsExpression("function(file, response) {
              $(file.previewElement).find('.dz-error-message').text(response);
          }"),
           'removedfile' => "function(file){alert(file.name + ' Telah dihapus')}"
       ],
   ]);


?>
<style type="text/css">
  .dropzone .dz-preview .dz-error-message {
    top: 150px!important;
}
</style>
<br/>
<h3>File Penunjang Saat Ini</h3>
<div class="row">
		<?php foreach($data as $key => $val): ?>
			<div class="col-md-2">
				
				<?= @getimagesize(Url::to('@web/'.$val['path'],true)) > 0 ? Html::a(Html::img('@web/'.$val['path'],['style'=>'height:170px','class'=>'img-responsive']),Url::to('@web/'.$val['path'],true)) : Html::a(substr(str_replace('rm_penunjang/', '', $val['path']),5),Url::to('@web/'.$val['path'],true),['class' => 'btn btn-lg green'])  ?>
			
			
				<?= 
				Html::a('<i class="fa fa-trash-o"></i>', Url::to(['rekam-medis/delete-penunjang','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['id'], Yii::$app->params['kunciInggris'] ))]), [
                        'title' => Yii::t('yii', 'Hapus'),
                        'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                        'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus File ini?'),
                        'data-method' => 'post',
                    ]);
				?>
			</div>
		<?php endforeach; ?>
</div>