<?php

namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property int|null $group_id
 * @property string|null $email
 * @property string|null $birth_date
 *
 * @property Group $group
 * @property integer $age
 */
class User extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['group_id'], 'integer'],
			[['birth_date'], 'safe'],
			[['email'], 'string', 'max' => 255],
			[['email'], 'unique'],
			[['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'group_id' => 'Group ID',
			'email' => 'Email',
			'birth_date' => 'Birth Date',
		];
	}

	/**
	 * Gets query for [[Group]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getGroup()
	{
		return $this->hasOne(Group::class, ['id' => 'group_id']);
	}

	public function getAge()
	{
		$dob = new DateTime($this->birth_date);

		$now = new DateTime();

		$difference = $now->diff($dob);

		return $difference->y;
	}
}
