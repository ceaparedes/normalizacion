<?php

namespace app\controllers;

use Yii;
use app\models\TipoAccionSolicitud;
use app\models\TipoAccionSolicitudSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoAccionSolicitudController implements the CRUD actions for TipoAccionSolicitud model.
 */
class TipoAccionSolicitudController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TipoAccionSolicitud models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipoAccionSolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoAccionSolicitud model.
     * @param integer $ODO_ID
     * @param integer $TAS_ID
     * @return mixed
     */
    public function actionView($ODO_ID, $TAS_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ODO_ID, $TAS_ID),
        ]);
    }

    /**
     * Finds the TipoAccionSolicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ODO_ID
     * @param integer $TAS_ID
     * @return TipoAccionSolicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ODO_ID, $TAS_ID)
    {
        if (($model = TipoAccionSolicitud::findOne(['ODO_ID' => $ODO_ID, 'TAS_ID' => $TAS_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionLists($id){
        $countPosts = TipoAccionSolicitud::find()
                      ->where(['ODO_ID' => $id])
                      ->count();

        $posts =  TipoAccionSolicitud::find()
                      ->where(['ODO_ID' => $id])
                      ->all();

        if ($countPosts > 0){
          foreach ($posts as $post) {
            echo "<option value =". $post->TAS_ID."'>".$post->TAS_ACCION . "</option>";
          }
          else {
            echo "<option>-</option>";
          }
        }
    }


}
