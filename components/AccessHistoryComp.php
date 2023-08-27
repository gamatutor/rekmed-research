<?php
 
namespace app\components;
use app\models\AccessHistory;


class AccessHistoryComp extends \yii\base\Component{
	public function init() {
		$model = new AccessHistory();
		$model->saveAccess();
		parent::init();
	}
}

?>