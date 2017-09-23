<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'Account Activation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>


	<?php if (isset($activated) && $activated): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your account has been activated go to login page.
        </div>
	<?php else: ?>
        <div class="alert alert-warning">
            <strong>Fail!</strong> This key already activated or unknown.
        </div>
    <?php endif;?>
</div>
