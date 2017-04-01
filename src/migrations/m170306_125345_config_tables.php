<?php


use yii\db\Migration;

class m170306_125345_config_tables extends Migration
{
    public function up()
    {
        $this->createTable('{{%grid_config}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'grid_id' => $this->string('40')->notNull(),
            'config' => $this->binary(),
        ]);
        $this->createIndex('gconf', '{{%grid_config}}', ['grid_id', 'user_id'], true);
    }

    public function down()
    {
        $this->dropTable('{{%grid_config}}');
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
