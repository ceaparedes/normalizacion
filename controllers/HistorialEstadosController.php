<?php

namespace app\controllers;

use Yii;
//use yii models
use app\models\HistorialEstados;
use app\models\HistorialEstadosSearch;
//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * HistorialEstadosController implements the CRUD actions for HistorialEstados model.
 */
class HistorialEstadosController extends Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::classname(),
                'only'=>['answer','view'],
                'rules'=>[
                  [
                    'allow'=>true,
                    'actions' =>['answer','view'],
                    'roles'=>['@'],//cambiar al rol a funcionario R.
                  ],
                  [
                    'allow'=>true,
                    'actions' =>['view'],
                    'roles'=>['@'],//cambiar al rol a usuario
                  ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all HistorialEstados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistorialEstadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HistorialEstados model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the HistorialEstados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HistorialEstados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HistorialEstados::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
