<?php

namespace common\models;

class Role extends \yii\base\BaseObject
{
  public $id;
  public $title;

  public static function getIdAdminRole()
  {
    return \common\models\repository\Roles::find()->where(['title' => 'admin'])->one();
  }
}