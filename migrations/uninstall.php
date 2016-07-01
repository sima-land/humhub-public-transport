<?php

use yii\db\Migration;

class uninstall extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fk_schedule_route_id','ptm_schedule');
        $this->dropForeignKey('fk_route_direction_id','ptm_route');
        $this->dropForeignKey('fk_route_node_route_id','ptm_route_node');
        $this->dropForeignKey('fk_route_node_node_id','ptm_route_node');


        $this->dropTable('ptm_schedule');
        $this->dropTable('ptm_route_node');
        $this->dropTable('ptm_route');
        $this->dropTable('ptm_node');
        $this->dropTable('ptm_direction');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";

        return false;
    }
    
}
