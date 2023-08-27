<?php
use app\assets\NotificAsset;
NotificAsset::register($this);
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>

<?php
        Modal::begin([
                'header' => '<h4>Reminder</h4>',
                'id' => 'modal-reminder',
            ]);

        echo "<div id='modalContent-reminder'></div>";

        Modal::end();

    ?>


<?php 
	$string = '';
	foreach ($model as $key => $value) {
		$string .= 
		"
		$.notific8('<a href=\"javascript:;\" class=\"modalWindow-reminder\" style=\"color:white\" value=\"".Url::to(['pasien-next-visit/view','id'=>$value->pasien_schedule_id])."\">{$value->agenda}</a>', {
		  life: 5000,
		  heading: 'Reminder Pasien RM : <a href=\"javascript:;\" class=\"modalWindow-reminder\" style=\"color:white\" value=\"".Url::to(['pasien/view','id'=>$value->mr])."\">{$value->mr}</a>',
		  theme: 'teal',
		  sticky: true,
		  horizontalEdge: 'bottom',
		  verticalEdge: 'left',
		});
		";
	}

?>
<?php
$script = <<< JS
    $(function(){
        $('.modalWindow-reminder').click(function(){
            $('#modal-reminder').modal('show')
                .find('#modalContent-reminder')
                .load($(this).attr('value'))
        })
    });
JS;

$script .= $string;
$this->registerJs($script);
?>
