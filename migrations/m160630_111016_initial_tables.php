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
        // направление
        $this->createTable('ptm_direction', [
            'id' => $this->primaryKey(),
            'name'=> $this->char(100),
        ]);
        // маршрут
        $this->createTable('ptm_route', [
            'id' => $this->primaryKey(),
            'name'=> $this->char(100),
            'direction_id' => $this->integer(),
        ]);
        $this->addForeignKey('fk_route_direction_id', 'ptm_route', 'direction_id', 'ptm_direction', 'id', null, 'CASCADE');
        // остановка
        $this->createTable('ptm_node', [
            'id' => $this->primaryKey(),
            'name' => $this->char(100),
            'lat' => $this->float(10),
            'lng' => $this->float(10),
        ]);
        // связь остановки и маршрута
        $this->createTable('ptm_route_node', [
            'id' => $this->primaryKey(),
            'route_id'=> $this->integer(),
            'node_id' => $this->integer(),
            'node_interval' => $this->integer(),
        ]);
        $this->addForeignKey('fk_route_node_route_id', 'ptm_route_node', 'route_id', 'ptm_route', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_route_node_node_id', 'ptm_route_node', 'node_id', 'ptm_node', 'id', 'CASCADE', 'CASCADE');

        // расписание
        $this->createTable('ptm_schedule', [
            'id' => $this->primaryKey(),
            'departure_at' => $this->dateTime(),
            'route_id' => $this->integer(),
            'comment'  => $this->text(),
        ]);
        $this->addForeignKey('fk_schedule_route_id', 'ptm_schedule', 'route_id', 'ptm_route', 'id', 'CASCADE', 'CASCADE');

        $this->insert('ptm_direction', [
            'name' => 'На работу',
        ]);
        $this->insert('ptm_direction', [
            'name' => 'С работы',
        ]);
    }

    public function down()
    {
        echo "m160630_111016_initial_tables cannot be reverted.\n";

        return false;
    }
}
