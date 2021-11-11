<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 *
 * @property Group[] $groups
 * @property Group $parent
 * @property User[] $users
 * @property User $youngestUser
 * @property User $oldestUser
 * @property integer $avgAge
 * @property array $tree
 */
class Group extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%group}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['parent_id'], 'integer'],
			[['name'], 'string', 'max' => 255],
			[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['parent_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'parent_id' => 'Parent ID',
			'name' => 'Name',
		];
	}

	/**
	 * Gets query for [[Groups]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getGroups()
	{
		return $this->hasMany(Group::class, ['parent_id' => 'id']);
	}

	/**
	 * Gets query for [[Parent]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Group::class, ['id' => 'parent_id']);
	}

	/**
	 * Gets query for [[Users]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsers()
	{
		return $this->hasMany(User::class, ['group_id' => 'id']);
	}

	/**
	 * @return array|\yii\db\ActiveRecord|null
	 */
	public function getYoungestUser()
	{
		return User::find()->where(['group_id' => $this->id])->orderBy('birth_date DESC')->one();
	}

	/**
	 * @return array|\yii\db\ActiveRecord|null
	 */
	public function getOldestUser()
	{
		return User::find()->where(['group_id' => $this->id])->orderBy('birth_date ASC')->one();
	}

	/**
	 * @return float|int
	 */
	public function getAvgAge()
	{
		$avg_age_sum = 0;
		$group_users = $this->users;
		$group_count_users = count($group_users);

		foreach ($group_users as $user) {
			$avg_age_sum += $user->age;
		}

		if ($group_count_users)
			return round($avg_age_sum / $group_count_users);

		return 0;
	}

	/**
	 * @return array
	 */
	public function getTree(): array
	{
		if (empty($this->groups))
			return [];

		$child_groups = [];

		foreach ($this->groups as $group) {
			$child_groups[] = [
				'id' => $group->id, // if in project we set php8 easy way use unpack "...$group" instead of 'id' => $group->id, and 'name' => $group->name,
				'name' => $group->name, // if in project we set php8 easy way use unpack "...$group" instead of 'id' => $group->id, and 'name' => $group->name,
				'youngest_user' => $group->youngestUser->email ?? '',
				'oldest_user' => $group->oldestUser->email ?? '',
				'avg_age' => $group->avgAge,
				'child_groups' => $group->groups ? $group->tree : []
			];
		}

		return $child_groups;
	}
}
