<?php

namespace app\controllers;

use Yii;
//use models
use app\models\DerivacionReclamoSugerencia;
use app\models\DerivacionReclamoSugerenciaSearch;
use app\models\SolucionReclamoSugerencia;
use app\models\HistorialEstados;
use app\models\ReclamoSugerencia;
//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;

/**
 * DerivacionReclamoSugerenciaController implements the CRUD actions for DerivacionReclamoSugerencia model.
 */
class DerivacionReclamoSugerenciaController extends Controller
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
     * Lists all DerivacionReclamoSugerencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DerivacionReclamoSugerenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DerivacionReclamoSugerencia model.
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
     * Deletes an existing DerivacionReclamoSugerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAnswer($id)
    {
      $model = $this->findModel($id);
      $solucion = new SolucionReclamoSugerencia();
      $solucion = $solucion->findOne($model->SRS_ID);


      //validacion con ajax
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return \yii\widgets\ActiveForm::validate($model);
      }

      if ($model->load(Yii::$app->request->post()) )
      {
     $historial = new HistorialEstados();
        //proceso para traer el reclamo correspondiente
        $reclamo = new ReclamoSugerencia();
        //revisar estas querys que no estan trabajando como corresponde
        $query = new Query;
        $query->select ('REC_NUMERO')
            ->from('RECLAMO_SUGERENCIA')
            ->where('REC_NUMERO=:numero', [':numero' => $solucion->REC_NUMERO])
            ->limit('1');
        $query = $query->one();
        $reclamo = $reclamo->findOne($query);
        //end proceso
        $model->DRS_FECHA_RESPUESTA = date('Y-m-d');
        $model->EDR_ID = 2;
        $model->save();
        //historial
        $historial->REC_NUMERO = $reclamo->REC_NUMERO;
        $historial->ERS_ID = $reclamo->ERS_ID;
        $historial->USU_RUT = $reclamo->USU_RUT;
        $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
        $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Respondido a la derivación de la solicitud Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
        $historial->save();
        //end historial
        return $this->redirect(['view', 'id' => $model->DRS_ID]);

      }else{
        return $this->render('answer', [
            'model' => $model,
            'solucion' => $solucion,
            ]);
          }
        }



    /**
     * Finds the DerivacionReclamoSugerencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DerivacionReclamoSugerencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DerivacionReclamoSugerencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
