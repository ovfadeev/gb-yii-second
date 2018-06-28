<?php

namespace common\models;


class Task extends \yii\base\BaseObject
{
  public $id;
  public $name;
  public $created_at;
  public $update_at;
  public $deadline;
  public $description;
  public $autor_id;
  public $performer_id;
  public $status_id;

}