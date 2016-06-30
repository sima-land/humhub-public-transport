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
        $this->createTable('node', [
            'id' => $this->primaryKey(),
            'name' => $this->char(40),
            'coor_x'=>$this->float(10),
            'coor_y'=>$this->float(10),
        ]);
        $this->createTable('route', [
            'id' => $this->primaryKey(),
            'direction_id'=>$this->integer(),
            'title'=>$this->char(50),
        ]);
        $this->createTable('direction', [
            'id' => $this->primaryKey(),
            'direction'=>$this->char(10),
        ]);
        $this->createTable('schedule', [
            'date_at' => $this->date(),
            'route_id'=>$this->integer(),
            'start_time'=>$this->time(),
            'comment'=>$this->text(),
        ]);
        $this->createTable('route_node', [
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
            'direction'=> 'на работу',
        ]);
        $this->insert('direction', [
            'direction'=> 'с работы',
        ]);
    }

    public function safeDown()
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
}
