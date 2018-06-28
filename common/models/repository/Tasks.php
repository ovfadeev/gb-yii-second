<?php

namespace common\models\repository;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deadline
 * @property string $description
 * @property int $autor_id
 * @property int $performer_id
 * @property int $status_id
 *
 * @property Comments[] $comments
 * @property User $autor
 * @property User $performer
 * @property StatusTasks $status
 */
class Tasks extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'tasks';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['name', 'description', 'autor_id', 'performer_id'], 'required'],
        [['created_at', 'updated_at', 'deadline'], 'safe'],
        [['description'], 'string'],
        [['autor_id', 'performer_id', 'status_id'], 'integer'],
        [['name'], 'string', 'max' => 150],
        [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['autor_id' => 'id']],
        [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'id']],
        [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusTasks::className(), 'targetAttribute' => ['status_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'name' => 'Name',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deadline' => 'Deadline',
        'description' => 'Description',
        'autor_id' => 'Autor ID',
        'performer_id' => 'Performer ID',
        'status_id' => 'Status ID',
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasMany(Comments::className(), ['task_id' => 'id']);
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
  public function getPerformer()
  {
    return $this->hasOne(User::className(), ['id' => 'performer_id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getStatus()
  {
    return $this->hasOne(StatusTasks::className(), ['id' => 'status_id']);
  }

  public static function getTasksDeadlineOnDays($idUser, $nDay, $nMonth, $nYear)
  {
    return self::find()
        ->where([
            'performer_id' => $idUser
        ])
        ->andWhere([
            'YEAR(deadline)' => $nYear
        ])
        ->andWhere([
            'MONTH(deadline)' => $nMonth
        ])
        ->andWhere([
            'DAY(deadline)' => $nDay
        ]);
  }

  public static function getTasksDeadlineExpiring()
  {
    return self::find()
        ->where([
            '<=',
            'deadline',
            date('Y-m-d H:i:s')
        ])
        ->andWhere([
            '<>',
            'status_id',
            StatusTasks::find()->where(['title' => 'Close'])->one()->id
        ])
        ->all();
  }
}
