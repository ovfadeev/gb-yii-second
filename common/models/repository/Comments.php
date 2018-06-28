<?php

namespace common\models\repository;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $text
 * @property int $task_id
 * @property int $autor_id
 * @property int $file_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $autor
 * @property Files $file
 * @property Tasks $task
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'task_id', 'autor_id'], 'required'],
            [['text'], 'string'],
            [['task_id', 'autor_id', 'file_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['autor_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'task_id' => 'Task ID',
            'autor_id' => 'Autor ID',
            'file_id' => 'File ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(User::className(), ['id' => 'autor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
