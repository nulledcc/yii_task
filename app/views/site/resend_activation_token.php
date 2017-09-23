<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ResendActivationForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'Resend activation token';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-token">
    <h1><?= Html::encode($this->title) ?></h1>
	<?php if (!isset($mail_sent) && !$mail_sent): ?>
        <p>Please fill out the following fields to send activation token:</p>

		<?php $form = ActiveForm::begin([
			'id'          => 'resend-token-form',
			'layout'      => 'horizontal',
			'fieldConfig' => [
				'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
				'labelOptions' => ['class' => 'col-lg-1 control-label'],
			],
		]); ?>
		<?= $form->field($model, 'username')->textInput(['value' => $username]) ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
				<?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
            </div>
        </div>

		<?php ActiveForm::end(); ?>
	<?php endif; ?>
	<?php if (isset($mail_sent) && $mail_sent): ?>
        <div class="alert alert-success">
            <strong>Mail Sent!</strong> Activation link has been sent to your e-mail address.
        </div>
	<?php endif; ?>
</div>
