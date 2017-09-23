<?php
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
	<h2>Activate your account by clicking <a href="<?=Url::home('http')?>activate/?key=<?=$key;?>">this link</a></h2>