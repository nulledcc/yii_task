<?php

namespace app\controllers;

use app\models\RegisterForm;
use Yii;
use app\models\User;
use yii\data\Pagination;

class AdminController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'rules' => [
					// allow authenticated users
					[
						'allow' => true,
						'roles' => ['@'],
					]
				],
			],
		];
	}

	public function actionIndex()
	{
		if (!Yii::$app->user->isGuest && User::is_role('admin'))
		{
			return $this->render('index');
		}
		else
		{
			return $this->redirect(Yii::$app->homeUrl);
		}
	}

	public function actionAddAccount()
	{
		if (!Yii::$app->user->isGuest && User::is_role('admin'))
		{
			$model = new RegisterForm();
			if ($model->load(Yii::$app->request->post()) && $model->register())
			{
				SiteController::sendActivationLink($model->activation_key,$model->email);
			}

			return $this->render('addAccount', [
				'model' => $model
			]);
		}
		else
		{
			return $this->redirect(Yii::$app->homeUrl);
		}
	}

	public function actionAccounts()
	{
		if (!Yii::$app->user->isGuest && User::is_role('admin'))
		{
			// build a DB query to get all articles with status = 1
			$query = User::find()->where("`id` != " . Yii::$app->user->getId());

			// get the total number of articles (but do not fetch the article data yet)
			$count = $query->count();

			// create a pagination object with the total count
			$pagination = new Pagination(['totalCount' => $count]);

			// limit the query using the pagination and retrieve the articles
			$user_list = $query->offset($pagination->offset)
				->limit($pagination->limit)
				->all();

			return $this->render('accounts', [
				'user_list'  => $user_list,
				'pagination' => $pagination
			]);
		}
		else
		{
			return $this->redirect(Yii::$app->homeUrl);
		}
	}
}
