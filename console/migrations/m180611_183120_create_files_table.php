<?php

use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m180611_183120_create_files_table extends Migration
{
  const TABLE_NAME_FILES = '{{%files}}';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this::TABLE_NAME_FILES, [
        'id' => $this->primaryKey(),
        'name' => $this->string(255)->notNull(),
        'path' => $this->string(255)->notNull(),
        'resize_path' => $this->string(255),
        'type' => $this->string(255)->notNull(),
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
        'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('files');
  }
}
