<?php

namespace app\controllers\api;

class BaseController extends \yii\web\Controller
{
	public function behaviors() {
		return [
			[
				'class' => \yii\filters\ContentNegotiator::class,
				'only' => ['index', 'show'],
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}
}