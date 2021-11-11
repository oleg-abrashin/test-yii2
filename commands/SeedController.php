<?php

namespace app\commands;

use app\models\Group;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
	/**
	 * This command generate fake users.
	 * @param integer $group_id group_id for user
	 * @return int Exit code
	 */
	public function actionUser($group_id = 0, $count = 20)
	{
		if ($group_id) {
			$faker = \Faker\Factory::create();
			$group = Group::findOne($group_id);

			if ($group) {
				for ($i = 1; $i <= $count; $i++) {
					$user = new User();
					$user->group_id = $group_id;
					$user->email = $faker->email;
					$user->birth_date = $faker->date();
					$user->save();
				}
			} else {
				echo "Incorrect group id!";
			}
		} else {
			echo "Please enter group_id!";
		}

		return ExitCode::OK;
	}

	/**
	 * This command generate fake groups.
	 * @return int
	 */
	public function actionGroup()
	{
		for ($i = 1; $i <= 20; $i++) {
			$firstLevelGroup = new Group();
			$firstLevelGroup->name = "Group " . $i;

			if ($firstLevelGroup->save()) {
				for ($j = 1; $j <= 2; $j++) {
					$secondLevelGroup = new Group();
					$secondLevelGroup->parent_id = $firstLevelGroup->id;
					$secondLevelGroup->name = "Group " . $i . "." . $j;
					if ($secondLevelGroup->save()) {
						for ($k = 1; $k <= 3; $k++) {
							$thirdLevelGroup = new Group();
							$thirdLevelGroup->parent_id = $secondLevelGroup->id;
							$thirdLevelGroup->name = "Group " . $i . "." . $j . "." . $k;
							$thirdLevelGroup->save();
						}
					}
				}
			}
		}

		return ExitCode::OK;
	}
}
