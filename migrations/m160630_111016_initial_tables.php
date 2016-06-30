<?php

use yii\db\Migration;

/**
 * Class m160630_111016_initial_tables creating tables into humhub db: node,route,schedule,connector
 * Class making foreignKeys to connect routes
 */

class m160630_111016_initial_tables extends Migration
{
    public function up()
    {
        $this->createTable('node', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'coordinates' => $this->text()
        ]);
        $this->createTable('route', [
            'id' => $this->primaryKey(),
            'direction'=>$this->boolean(),
            'title'=>$this->text(),
            'def_bus_id'=>$this->integer(),
        ]);
        $this->createTable('schedule', array(
            'date_time' => $this->date(),
            'route_id'=>$this->integer(),
            'start_time'=>$this->time(),
            'comment'=>$this->text(),
        ));
        $this->createTable('connector', [
            'route_id' => $this->integer(),
            'node_id' => $this->integer(),
            'interval'=>$this->text(),
        ]);

        $this->addForeignKey('r_id','schedule','route_id','route','id',null,null);
        $this->addForeignKey('r2_id','connector','route_id','route','id',null,null);
        $this->addForeignKey('n_id','connector','node_id','node','id',null,null);
        $this->addForeignKey('def_b_id','route','def_bus_id','connector','route_id',null,null);
    }

    public function down()
    {

        $this->dropForeignKey('def_b_id','route');
        $this->dropIndex('def_b_id','route');

        $this->dropForeignKey('r2_id','connector');
        $this->dropForeignKey('n_id','connector');

        $this->dropIndex('r2_id','connector');
        $this->dropIndex('n_id','connector');

        $this->dropTable('schedule');
        $this->dropTable('connector');
        $this->dropTable('route');
        $this->dropTable('node');
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
