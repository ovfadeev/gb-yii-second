<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\repository\Tasks;

$this->title = 'My tasks';
$this->params['breadcrumbs'][] = 'My tasks';

$paramsCache = [
    'duration' => Yii::$app->params['cache_time'],
    'dependency' => [
        'class' => 'yii\caching\DbDependency',
        'sql' => Tasks::find()
            ->select('MAX(updated_at)')
            ->where(['performer_id' => $data['user']])
            ->limit('1')
            ->prepare(Yii::$app->db->queryBuilder)
            ->createCommand()
            ->getRawSql()
    ],
    'enabled' => true,
    'variations' => [
        $data['user'],
        $data['cur_year'],
        $data['cur_month']
    ]
];

if ($this->beginCache('usertask', $paramsCache)) { ?>
  <div class="my-tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="bg-success">
          Days
        </th>
        <th>
          Tasks
        </th>
      </tr>
      </thead>
      <tbody>
      <?php
      foreach ($data['calendar'] as $day => $model) {
        echo '<tr>';
        echo '<th class="bg-success">' . $day . '</th>';
        echo '<th>';
        $dataProvider = new ActiveDataProvider([
            'query' => $model
        ]);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'deadline',
                'description:html',
                'autor_id' => [
                    'attribute' => 'autor_id',
                    'value' => function ($model) {
                      $user = $model->getAutor()->where(['id' => $model->autor_id])->one();
                      return $user->getFullName();
                    }
                ],
                'status_id' => [
                    'attribute' => 'status_id',
                    'value' => function ($model) {
                      $status = $model->getStatus()->where(['id' => $model->status_id])->one();
                      return $status->title;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn'
                ],
            ],
        ]);
        echo '</th>';
        echo '</tr>';
      }
      ?>
      </tbody>
    </table>
  </div>
  <?php

  $this->endCache();
}