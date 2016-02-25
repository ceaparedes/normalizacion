<?php

namespace app\controllers;

use Yii;
//use models
use app\models\ReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\ReclamoSugerenciaSearch;
use app\models\HistorialEstados;
use app\models\Adjuntos;
//herramientas de yii
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\web\UploadedFile;

/**
 * ReclamoSugerenciaController implements the CRUD actions for ReclamoSugerencia model.
 */

 /*
 **Estados de Reclamos y Sugerencias**
 1.-guardado
 2.-Enviado Por el usuario
 3.-Aprobado por Normalizacion
 4.-Rechazado por Normalizacion
 5.-Derivado al Responsable
 6.-Respondido por el Responsable
 7.-Respuesta Aprobada por el usuario
 8.-Cerrado
 9.-Eliminado

 */
class ReclamoSugerenciaController extends Controller
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
     * Lists all ReclamoSugerencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReclamoSugerenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReclamoSugerencia model.
     * @param string $id
     * @return mixed
     */

    public function actionView($id)
    {
      $model = $this->findModel($id);
      $query = new Query;
      //buscar el adjunto según el numero del reclamo
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO])
          ->limit('1');
      $query = $query->one();
      //si existe el reclamo crea la instancia, sino deja la variable null
      if ($query){
        $adjunto = new Adjuntos();
        $adjunto = $adjunto->findOne($query);
      }else{
        $adjunto = null;
      }

      //buscar la solucion al reclamo o sugerencia
      $solQuery = new Query;
      $solQuery->select ('SRS_ID')
          ->from('SOLUCION_RECLAMO_SUGERENCIA')
          ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO])
          ->limit('1');
      $solQuery = $solQuery->one();

      if($solQuery){
      $solucion = new SolucionReclamoSugerencia();
      $solucion = $solucion->findOne($solQuery);
    }else {
      $solucion = null;
    }

        return $this->render('view', [
            'model' => $model,
            'adjunto' =>$adjunto,
            'solucion'=>$solucion,
        ]);
    }

    /**
     * Creates a new ReclamoSugerencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
       {
           $model = new ReclamoSugerencia();
           //validacion ajax
           if(Yii::$app->request->isAjax && $model->load($_POST))
           {
             Yii::$app->response->format = 'json';
             return \yii\widgets\ActiveForm::validate($model);
           }

           if ($model->load(Yii::$app->request->post())) {


               $model->REC_FECHA = date('Y-m-d');
               $model->REC_HORA = date('H:i:s');
               $query = new Query;
               $query->select ('REC_NUMERO')
                   ->from('RECLAMO_SUGERENCIA')
                   ->where('YEAR(REC_FECHA) = DATEPART(yyyy,getDate())')
                   ->orderBy('REC_NUMERO DESC')
                   ->limit('1');

               $rows = $query->one();
               $current_year = date('Y');
               if ($rows){
                   $past = implode($rows);
                   $id = explode("-", $past);
                   $tmp_last_id = (int) $id[0] + 1;
                   if($current_year != $id[1]) $tmp_last_id = 0;
                   $digits_count = preg_match_all("/[0-9]/", $tmp_last_id);
                   $last_id = $tmp_last_id . "-" . $current_year;
                   if($digits_count < 2) {
                     $last_id = 0 . $last_id;
                   }
                 }else {
                   $new_id = 0 . "-". $current_year;
                   $last_id = 0 . $new_id;
                 }
             $model->REC_NUMERO = $last_id;
             $model->ERS_ID = 1;

             //Instancia para el adjunto
             $name = 'solicitud ' . $model->REC_NUMERO . ' '. $model->REC_FECHA . ' ' . date('H i');
             $model->file = UploadedFile::getInstance($model,'file');
             $model->save();
             //si el archivo no es null, entonces lo guarda y guarda el adjunto en la bd.
              if ($model->file != null){
             $model->file->saveAs('uploads/reclamo-sugerencia/Adjunto '. $name . '.' .$model->file->extension);
             //guardar la ruta en la bd
             $adjunto = new Adjuntos();
             $adjunto->REC_NUMERO = $model->REC_NUMERO;
             $adjunto->ADJ_TIPO = 'Reclamo-Sugerencia';
             $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/Adjunto '. $name . '.' .$model->file->extension;
             $adjunto->save();
            }

              //guardar Creacion en el Historial
              /*
              $historial = new HistorialEstados();
              $historial->REC_NUMERO = $model->REC_NUMERO;
              $historial->ERS_ID = $model->ERS_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              if($model->TRS_ID == 1){
                  $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;

              }else{
                      $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado la Sugerencia Nº ". $historial->REC_NUMERO .  " el día ". $historial->HES_FECHA_HORA;
                }
                $historial->save();
                */
              return $this->redirect(['view', 'id' => $model->REC_NUMERO]);
           } else {
               return $this->render('create', [
                   'model' => $model,
               ]);
           }
       }


    /**
     * Updates an existing ReclamoSugerencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //condicion para que ejecute ajax
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post())) {
          $model->REC_FECHA = date('Y-m-d');
          $model->REC_HORA = date('H:i:s');
          //Instancia para el adjunto
          $name = 'solicitud ' . $model->REC_NUMERO . ' '. $model->REC_FECHA . ' ' . date('H i');
          $model->file = UploadedFile::getInstance($model,'file');
          $model->save();

          if ($model->file != null){
         $model->file->saveAs('uploads/reclamo-sugerencia/Adjunto '. $name . '.' .$model->file->extension);
         //guardar la ruta en la bd
         $adjunto = new Adjuntos();
         $adjunto->REC_NUMERO = $model->REC_NUMERO;
         $adjunto->ADJ_TIPO = 'Reclamo-Sugerencia';
         $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/Adjunto '. $name . '.' .$model->file->extension;
         $adjunto->save();
        }
          return $this->redirect(['view', 'id' => $model->REC_NUMERO]);

          }else {

            return $this->render('create', [
                'model' => $model,
            ]);
      }
    }

    /**
     * Deletes an existing ReclamoSugerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      if($model->ERS_ID == 1){
        $model->ERS_ID = 8;
        $motivo = $model->REC_MOTIVO;
        $model->REC_MOTIVO = $motivo;
        $model->save();
        return $this->redirect(['index']);
      }

      return $this->redirect(['site/index']);//parche
    }


    //funcion que envía el reclamo-sugerencia
    public function actionSend($id){

        $model = $this->findModel($id);

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



         $model->REC_FECHA = date('Y-m-d');
         $model->REC_HORA = date('H:i:s');
         $model->ERS_ID = 2;
         $motivo = $model->REC_MOTIVO;
         $model->REC_MOTIVO = $motivo;
         $model->save();

         //instancia para crear el Historial;
         $historial = new HistorialEstados();
         $historial->REC_NUMERO = $model->REC_NUMERO;
         $historial->ERS_ID = $model->ERS_ID;
         $historial->USU_RUT = $model->USU_RUT;
         $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
         if($model->TRS_ID == 1){
             $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;

         }else{
                 $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado la Sugerencia Nº ". $historial->REC_NUMERO .  " el día ". $historial->HES_FECHA_HORA;
           }
           $historial->save();

           return $this->redirect(['view', 'id' => $model->REC_NUMERO]);

    }

/* funcion que evalua el reclamo/sugerencia, autorizandola o rechazandola*/
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);
        $solucion = new SolucionReclamoSugerencia();

        if(Yii::$app->request->isAjax && $solucion->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }

        if ($solucion->load(Yii::$app->request->post()))
        {
          $solucion->ESR_ID = 1;
          $solucion->REC_NUMERO = $model->REC_NUMERO;
          $solucion->SRS_FECHA_ENVIO= date('Y-m-d');

          //Aprobar o rechazar el Reclamo o Sugerencia
          $historial = new HistorialEstados();
        if($solucion->SRS_VISTO_BUENO == 'Autorizado'){

              $model->ERS_ID = 3;
              $motivo = $model->REC_MOTIVO;
              $model->REC_MOTIVO = $motivo;
              $model->save();
              $solucion->save();
              //insertar en el historial la aprobacion
              $historial->REC_NUMERO = $model->REC_NUMERO;
              $historial->ERS_ID = $model->ERS_ID;
              $historial->USU_RUT = $solucion->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
              $historial->save();

          }else{
              $model->ERS_ID = 4;
              $motivo = $model->REC_MOTIVO;
              $model->REC_MOTIVO = $motivo;
              $model->save();
              $solucion->save();
              //insertar en e historial el rechazo
              $historial->REC_NUMERO = $model->REC_NUMERO;
              $historial->ERS_ID = $model->ERS_ID;
              $historial->USU_RUT = $solucion->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
              $historial->save();
            }
          //  $solucion->save();
          return $this->redirect(['/solucion-reclamo-sugerencia/view', 'id' => $solucion->SRS_ID]);



        } else {
            if($model->ERS_ID != 2){
              //soucion parche
              return $this->redirect(['/solucion-reclamo-sugerencia/index']);
            }else {
              return $this->render('evaluate', [
                  'model' => $model,
                  'solucion'=>$solucion,
              ]);
            }

        }
    }
    /**
     * Finds the ReclamoSugerencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ReclamoSugerencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReclamoSugerencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
