<?php

namespace frontend\controllers;

use common\models\File;
use common\models\repository\Comments;
use common\models\repository\Files;
use Yii;
use common\models\repository\Tasks;
use common\models\repository\StatusTasks;
use common\models\repository\User;
use yii\web\UploadedFile;

class MyTasksController extends \yii\web\Controller
{
  public function actionIndex()
  {
    return $this->render('index', [
        'data' => $this->getCalendar()
    ]);
  }

  public function actionView($id)
  {
    $model = $this->findModel($id);

    $modelComment = new Comments();
    $modelComment->autor_id = Yii::$app->user->identity->id;
    $modelComment->task_id = $model->id;

    $listComments = $model->getComments()->all();

    $modelFile = new File();

    return $this->render('view', [
        'model' => $model,
        'listComments' => $listComments,
        'modelComment' => $modelComment,
        'modelFile' => $modelFile
    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $model->autor_id = Yii::$app->user->identity->id;

    $status = StatusTasks::find()->all();

    $users = User::find()->all();

    return $this->render('update', [
        'model' => $model,
        'users' => $users,
        'status' => $status
    ]);
  }

  public function actionAddComment()
  {
    if (Yii::$app->request->isPost) {
      $modelFile = new File();
      $modelFile->file = UploadedFile::getInstance($modelFile, 'file');
      $modelFile->uploadFile();
      if ($modelFile->isImage()) {
        $modelFile->resizeImage(200, 200);
      }

      $files = new Files();

      $modelComment = new Comments();

      if ($files->load(['Files' => $modelFile->toArray(['name', 'path', 'resize_path', 'type'])]) && $files->save()) {
        $modelComment->file_id = $files->id;
      }

      if ($modelComment->load(Yii::$app->request->post()) && $modelComment->save()) {
        return $this->redirect(['view', 'id' => $modelComment->task_id]);
      }
    }
  }

  protected function findModel($id)
  {
    if (($model = Tasks::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

  protected function getCalendar()
  {
    $params = [
        'user' => Yii::$app->user->identity->id,
        'calendar' => array_fill_keys(range(1, date("t")), []),
        'cur_year' => date("Y"),
        'cur_month' => date("m")
    ];

    foreach ($params['calendar'] as $day => $value) {
      $params['calendar'][$day] = Tasks::getTasksDeadlineOnDays(
          $params['user'],
          $day,
          $params['cur_month'],
          $params['cur_year']
      );
    }

    return $params;
  }

}
