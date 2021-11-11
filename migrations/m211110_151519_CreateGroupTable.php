<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 */
class m211110_151519_CreateGroupTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
	        'parent_id' => $this->integer(),
	        'name' => $this->string(255),
        ]);

	    $this->addForeignKey('fk_user_group_idx', '{{%user}}', 'group_id', 'group', 'id');
	    $this->addForeignKey('fk_user_parent_idx', '{{%group}}', 'parent_id', 'group', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropForeignKey('fk_user_group_idx', '{{%user}}');
	    $this->dropForeignKey('fk_user_parent_idx', '{{%group}}');
        $this->dropTable('{{%group}}');
    }
}
