<?php

use yii\db\Migration;

class m160715_072111_insert_new_group extends Migration
{
    public function safeUp()
    {

        $this->insert('group', [
            'name' => 'transport_admin',
            'description' => 'Group for admins of the project'
        ]);


    }

    public function down()
    {
        echo "m160715_072111_insert_new_group cannot be reverted.\n";

        return false;
    }
}
