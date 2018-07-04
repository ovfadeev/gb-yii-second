<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'autor_id', [
      'template' => '{input}'
  ])->textInput(['type' => 'hidden']) ?>

  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'deadline')->widget(
      \kartik\datetime\DateTimePicker::className(),
      [
          'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
          'options' => [
              'placeholder' => 'Select deadline time ...'
          ]
      ]
  ) ?>

  <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

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
