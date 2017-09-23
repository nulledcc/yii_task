<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<p>
<a href="/admin/add-account">Add Account</a>
</p>
<p>
    <?php
    $provider = new ArrayDataProvider([
	    'allModels' => $user_list
    ]);
    ?>
    <?= GridView::widget([
	    'dataProvider' => $provider,
	    'columns' => [
		    ['class' => 'yii\grid\SerialColumn'],
		    'id',
		    'username:ntext',
		    'is_activated:ntext',
		    'created_date',
		    // 'updated_at',
		    ['class' => 'yii\grid\ActionColumn'],
	    ],
    ]); ?>
    <?=LinkPager::widget([
        'pagination' => $pagination,
    ]);?>
</p>
