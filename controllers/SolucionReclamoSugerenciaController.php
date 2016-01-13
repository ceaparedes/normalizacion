<?php

namespace app\controllers;

use Yii;
//use models
use app\models\HistorialEstados;
use app\models\SolucionReclamoSugerencia;
use app\models\SolucionReclamoSugerenciaSearch;
use app\models\ReclamoSugerencia;
use app\models\DerivacionReclamoSugerencia;
use app\models\Adjuntos;
//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
/**
 * SolucionReclamoSugerenciaController implements the CRUD actions for SolucionReclamoSugerencia model.
 */
class SolucionReclamoSugerenciaController extends Controller
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
     * Lists all SolucionReclamoSugerencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolucionReclamoSugerenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SolucionReclamoSugerencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $reclamo = new ReclamoSugerencia();
      $reclamo = $reclamo->findOne($model->REC_NUMERO);
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO])
          ->limit('1');
      $query = $query->one();
      if ($query){
        $adjunto = new Adjuntos();
        $adjunto = $adjunto->findOne($query);
      }else{
        $adjunto = null;
      }

        return $this->render('view', [
            'model' => $model,
            'adjunto' =>$adjunto,
            'reclamo' =>$reclamo,
        ]);
    }

    /**
     * Deletes an existing SolucionReclamoSugerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //funcion para evaluar la solucion del reclamo/Sugerencia
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);

        $reclamo = new ReclamoSugerencia();
        $reclamo = $reclamo->findOne($model->REC_NUMERO);
        //Proceso para traer la respuesta del afectado al solicitante
        $query = new Query;
        $query->select ('DRS_ID')
            ->from('DERIVACION_RECLAMO_SUGERENCIA')
            ->where('SRS_ID=:solucion', [':solucion' => $model->SRS_ID])
            ->limit('1');
        $query = $query->one();
        if($query){
        $respuesta = new DerivacionReclamoSugerencia();
        $respuesta = $respuesta->findOne($query);
      }else {
        $respuesta = NULL;
      }

        if ($reclamo->load(Yii::$app->request->post()))
        {
          $model->SRS_FECHA_RESPUESTA = date('Y-m-d');
          $historial = new HistorialEstados();
          $reclamo->save();//esto tiene que ir aca si o si
          $model->save();
          if($reclamo->REC_VISTO_BUENO == 'Autorizado'){
              $model->ESR_ID = 2;
              $reclamo->ERS_ID = 7;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA . "  cerrando el caso";
              $historial->save();
              //end historial
          }else{
              $model->ESR_ID = 3;
              $reclamo->ERS_ID = 1;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA .'. '. 'La solicitud debe ser modificada para que vuelva a ser evaluada.';
              $historial->save();
              //end Historial
          }
          return $this->redirect(['view', 'id' => $model->SRS_ID]);
        }else {
          return $this->render('evaluate', [
              'model' => $model,
              'reclamo'=>$reclamo,
              'respuesta'=>$respuesta,
          ]);
        }


    }

      public function actionResultados($id){
          $model = $this->findModel($id);
          $reclamo = new ReclamoSugerencia();
          $reclamo = $reclamo->findOne($model->REC_NUMERO);
          if ($model->load(Yii::$app->request->post()) && $model->save())
          {
            $historial = new HistorialEstados();
            //historial
            $historial->REC_NUMERO = $reclamo->REC_NUMERO;
            $historial->ERS_ID = $reclamo->ERS_ID;
            $historial->USU_RUT = $reclamo->USU_RUT;
            $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
            $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha escrito los resultados para la solucitud Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
            $historial->save();

            return $this->redirect(['view', 'id' => $model->SRS_ID]);

          }else{
            return $this->render('resultados', [
                'model' => $model,
                ]);
          }
        }

        public function actionDerivate($id){
          $model = $this->findModel($id);
          $derivacion = new DerivacionReclamoSugerencia();
          $reclamo = new ReclamoSugerencia();
          $reclamo = $reclamo->findOne($model->REC_NUMERO);
          //validacion ajax
          if(Yii::$app->request->isAjax && $model->load($_POST))
          {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
          }

          if ($derivacion->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $model->save())
          {
            $derivacion->DRS_FECHA_DERIVACION = date('Y-m-d');
            $derivacion->SRS_ID = $model->SRS_ID;
            $derivacion->EDR_ID = 1;
            $reclamo->ERS_ID = 5;
            $reclamo->save();
            $derivacion->save();
            //Historial
            $historial = new HistorialEstados();
            $historial->REC_NUMERO = $reclamo->REC_NUMERO;
            $historial->ERS_ID = $reclamo->ERS_ID;
            $historial->USU_RUT = $reclamo->USU_RUT;
            $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
            $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Derivado la solucitud Nº ". $historial->REC_NUMERO ." a la unidad  ".$derivacion->DRS_UNIDAD . " el día ". $historial->HES_FECHA_HORA;
            $historial->save();

            return $this->redirect(['derivacion-reclamo-sugerencia/view', 'id' => $derivacion->DRS_ID]);

          }else{
            return $this->render('derivate', [
                'model' => $model,
                'derivacion' => $derivacion,
                ]);
              }
            }



    /**
     * Finds the SolucionReclamoSugerencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SolucionReclamoSugerencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SolucionReclamoSugerencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
