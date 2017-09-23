<?php

namespace app\controllers;

use app\models\RegisterForm;
use app\models\ResendActivationForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow'   => true,
						'roles'   => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest)
		{
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login())
		{
			return $this->goBack();
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Register action.
	 *
	 * @return Response|string
	 */
	public function actionRegister()
	{
		if (!Yii::$app->user->isGuest)
		{
			return $this->goHome();
		}

		$model = new RegisterForm();
		if ($model->load(Yii::$app->request->post()) && $model->register())
		{
			self::sendActivationLink($model->activation_key,$model->email);
		}

		return $this->render('register', [
			'model' => $model,
		]);
	}

	/**
	 * resend activation.
	 *
	 * @return Response|string
	 */
	public function actionResend_activation_link()
	{
		if (!Yii::$app->user->isGuest)
		{
			return $this->goHome();
		}

		$model = new ResendActivationForm();
		if ($model->load(Yii::$app->request->post()) && ($activation_token = $model->getActivationToken()))
		{
			self::sendActivationLink($activation_token,$model->getEmail());
			return $this->render('resend_activation_token', [
				'mail_sent' => true
			]);
		}
		$user = Yii::$app->request->get('u');
		return $this->render('resend_activation_token', [
			'model' => $model,
			'username' => $user
		]);
	}
	/**
	 * Send activation link.
	 *
	 * @return bool
	 */
	public static function sendActivationLink($key,$email)
	{
		return Yii::$app->mailer->compose('activation_mail',[
			'key' => $key
		]) // a view rendering result becomes the message body here
		->setFrom(Yii::$app->params['noreply_mail'])
			->setTo($email)
			->setSubject('Activate your account')
			->send();
	}
	/**
	 * Send activation link.
	 *
	 * @return bool
	 */
	public function actionActivate()
	{
		$key = Yii::$app->request->get('key');
		$activated = User::activate($key);
		return $this->render('activation', [
			'activated' => $activated
		]);
	}
	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail']))
		{
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}

		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}
}
