<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\repository\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'name')->textInput(['disabled' => 'disabled']) ?>

  <?= $form->field($model, 'autor_id')->dropDownList(
      ArrayHelper::map($users, 'id', 'username'),
      [
          'disabled' => 'disabled'
      ]
  ) ?>

  <?= $form->field($model, 'deadline')->textInput(['disabled' => 'disabled']) ?>
  <?= Html::error($model, 'dealine'); ?>

  <?= $form->field($model, 'description')->textarea([
      'rows' => 6,
      'disabled' => 'disabled'
  ]) ?>

  <?= $form->field($model, 'performer_id')->dropDownList(ArrayHelper::map($users, 'id', 'username')) ?>
  <?
  if ($status) {
    echo $form->field($model, 'status_id')->dropDownList(ArrayHelper::map($status, 'id', 'title'));
  } else {
    echo $form->field($model, 'status_id', [
        'template' => '{input}'
    ])->textInput(['type' => 'hidden']);
  }
  ?>

  <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
