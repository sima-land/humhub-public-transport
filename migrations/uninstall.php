<?php

use yii\db\Migration;

class uninstall extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fk_schedule_route_id','schedule');
        $this->dropForeignKey('fk_route_direction_id','route');
        $this->dropForeignKey('fk_route_node_route_id','route_node');
        $this->dropForeignKey('fk_route_node_node_id','route_node');


        $this->dropTable('schedule');
        $this->dropTable('route_node');
        $this->dropTable('route');
        $this->dropTable('node');
        $this->dropTable('direction');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";

        return false;
    }
    
}
