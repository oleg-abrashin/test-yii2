<?php

namespace app\controllers\api;

use app\models\Group;
use app\models\User;
use yii\db\Query;

class GroupController extends BaseController
{
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * @param integer $id
	 */
	public function actionShow($id)
	{
		if (!$group = Group::findOne($id))
			return [
				'error' => true,
				'message' => "Group not found!"
			];

		$mappedGroups = [
			'id' => $group->id, // if in project we set php8 easy way use unpack "...$group" instead of 'id' => $group->id, and 'name' => $group->name,
			'name' => $group->name, // if in project we set php8 easy way use unpack "...$group" instead of 'id' => $group->id, and 'name' => $group->name,
			'youngest_user' => $group->youngestUser->email ?? '',
			'oldest_user' => $group->oldestUser->email ?? '',
			'avg_age' => $group->avgAge,
			'child_groups' => $group->tree
		];


		return $mappedGroups;
	}

}
