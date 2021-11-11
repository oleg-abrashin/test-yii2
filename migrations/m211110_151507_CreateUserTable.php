<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m211110_151507_CreateUserTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
	        'group_id' => $this->integer(),
	        'email' => $this->string(255),
	        'birth_date' => $this->dateTime(),
        ]);

		$this->createIndex('email_UNIQUE', '{{%user}}', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropIndex('email_UNIQUE', '{{%user}}');
	    $this->dropTable('{{%user}}');
    }
}
