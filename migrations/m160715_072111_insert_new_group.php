<?php

use yii\db\Migration;

class m160715_072111_insert_new_group extends Migration
{
    public function safeUp()
    {

        $this->insert('group', [
            'name' => 'PublicTransportMap',
            'description' => 'Group for admins of the project'
        ]);


    }

    public function down()
    {
        echo "m160715_072111_insert_new_group cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
