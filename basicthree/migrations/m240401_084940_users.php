<?php

use yii\db\Migration;

/**
 * Class m240401_084940_users
 */
class m240401_084940_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240401_084940_users cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            // Add other columns as needed
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');

    }
}
