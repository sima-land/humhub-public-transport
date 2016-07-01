<?php

use yii\db\Migration;

/**
 * Class m160630_111016_initial_tables creating tables into humhub db: node,route,schedule,connector
 * Class making foreignKeys to connect routes
 */

class m160630_111016_initial_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('ptm_node', [
            'id' => $this->primaryKey(),
            'name' => $this->char(40),
            'lat'=>$this->float(10),
            'lng'=>$this->float(10),
        ]);
        $this->createTable('ptm_route', [
            'id' => $this->primaryKey(),
            'direction_id'=>$this->integer(),
            'title'=>$this->char(50),
        ]);
        $this->createTable('ptm_direction', [
            'id' => $this->primaryKey(),
            'description'=>$this->char(10),
        ]);
        $this->createTable('ptm_schedule', [
            'id'=>$this->primaryKey(),
            'start_at' => $this->dateTime(),
            'route_id'=>$this->integer(),
            'comment'=>$this->text(),
        ]);
        $this->createTable('ptm_route_node', [
            'route_id' => $this->integer(),
            'node_id' => $this->integer(),
            'node_interval'=>$this->text(),
        ]);

        $this->addPrimaryKey('pk_route_node_route_id_node_id','route_node','route_id,node_id');

        $this->addForeignKey('fk_schedule_route_id','schedule','route_id','route','id',null,null);
        $this->addForeignKey('fk_route_node_route_id','route_node','route_id','route','id',null,null);
        $this->addForeignKey('fk_route_node_node_id','route_node','node_id','node','id',null,null);
        $this->addForeignKey('fk_route_direction_id','route','direction_id','direction','id',null,null);

        $this->insert('direction', [
            'description'=> 'на работу',
        ]);
        $this->insert('direction', [
            'description'=> 'с работы',
        ]);
    }

    public function down()
    {
        echo "m160630_111016_initial_tables cannot be reverted.\n";

        return false;
    }
}
