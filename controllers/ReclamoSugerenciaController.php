<?php

namespace app\controllers;

use Yii;
//use models
use app\models\ReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\DerivacionReclamoSugerencia;
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
use yii\filters\AccessControl;

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
            'access'=>[
                'class'=>AccessControl::classname(),
                'only'=>['create','update','delete','send','view','evaluate','derivate','index'],
                'rules'=>[
                  [
                    'allow'=>true,
                    'actions' =>['create','update','delete','send','view','index'],
                    'roles'=>['@'],//cambiar al rol usuario
                  ],
                  [
                    'allow'=>true,
                    'actions' =>['create','update','delete','send','view','evaluate'],
                    'roles'=>['@'],//cambiar al rol JDNYC
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
/*********VIEW DEL MODULO DE RECLAMOS Y SUGERENCIAS****************/
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $query = new Query;
      //buscar el adjunto según el numero del reclamo
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
      $query = $query->All();

      //si existe el reclamo crea la instancia, sino deja la variable null
      if ($query){
        $contador = count($query);

      }else{
        $contador = null;
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
        $deQuery = new Query;
        $deQuery->select ('DRS_ID')
            ->from('DERIVACION_RECLAMO_SUGERENCIA')
            ->where('SRS_ID=:solucion', [':solucion' => $solucion->SRS_ID])
            ->limit('1');
        $deQuery = $deQuery->one();
        if($deQuery){
          $derivacion = new DerivacionReclamoSugerencia();
          $derivacion = $derivacion->findOne($deQuery);
        }else {
          $derivacion = NULL;
        }

    }else {
      $solucion = null;
      $derivacion = NULL;
    }

        /* //carga de sp cuando este disponible
        $rut = Yii::$app->user->identity->rut;
        $sp = "ubb..sp_web_identificacion $rut";
        $resultado = Yii::$app->dbubb->createCommand($sp)->queryOne();
        */
        /*
        $connection = Yii::$app->dbcreditotest;
        $sp = ' select * from Creditotest..JEFATURA_CONTRATO j
        where j.jco_fecha_inicio <= GETDATE()
        and (j.jco_fecha_termino >= GETDATE() or jco_fecha_termino is null )
        and j.rep_codigo = 30400000';
        $jdnyc = $connection->createCommand($sp)->queryOne();*/

        $tipo_usuario = Yii::$app->user->identity->tipo_usuario;
        if($tipo_usuario == 'ALUMNO'){
          return $this->render('view2', [
              'model' => $model,

              'solucion'=>$solucion,
              'derivacion'=>$derivacion,
              'contador' => $contador,
          ]);

        }elseif($tipo_usuario == 'ADMINISTRATIVO') {
          return $this->render('view', [
              'model' => $model,

              'solucion'=>$solucion,
              'derivacion'=>$derivacion,
              'contador' => $contador,
          ]);
        }
        $this->goBack();
    }

    /**
     * Creates a new ReclamoSugerencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/**********************CREACION DEL RECLAMO SUGERENCIA***********************/
   public function actionCreate()
     {
         $model = new ReclamoSugerencia();
          Yii::$app->controller->enableCsrfValidation = false;
         //validacion ajax
         if(Yii::$app->request->isAjax && $model->load($_POST))
         {
           Yii::$app->response->format = 'json';
           return \yii\widgets\ActiveForm::validate($model);
         }

         if ($model->load(Yii::$app->request->post())) {

             $model->REC_FECHA = date('Y-m-d');
             $model->REC_HORA = date('H:i:s');
             //funcion que trae el reclamo anterior
             $query = new Query;
             $query->select ('REC_NUMERO')
                 ->from('RECLAMO_SUGERENCIA')
                 ->where('YEAR(REC_FECHA) = DATEPART(yyyy,getDate())')
                 ->orderBy('REC_NUMERO DESC')
                 ->limit('1');
            //funcion que asigna el numero de la solicitud
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

           //insert con variables del usuario (conexion con el sp)
           $rut = Yii::$app->user->identity->rut;
           $sp = "ubb..sp_web_identificacion $rut";
           $resultado = Yii::$app->dbubb->createCommand($sp)->queryOne();

           $model->USU_RUT = Yii::$app->user->identity->rut;
           $model->REC_NOMBRE_USUARIO = $resultado['nombres'] . ' ' . $resultado ['paterno'] . ' ' . $resultado['materno'];
           //descomentar cuando tenga el sp correspondiente.
           //$model->REC_EMAIL_USUARIO = Yii::$app->user->identity->correo;

           //filtro temporal de usuario
           $tipo_usuario = Yii::$app->user->identity->tipo_usuario;
           $situacion_academica = Yii::$app->user->identity->sit_acad;

           /*la asignacion del correo temporalmente se hara en esta validacion, ya que el yii no reconoce los correos de los administrativos*/
           //filtro para el tipo de usuario
           if($tipo_usuario == 'ADMINISTRATIVO'){
             $model->TSR_ID = 1;
            }else {
               if( $situacion_academica  == 'REGULAR'){
                 $model->TSR_ID = 2;
                 $model->REC_EMAIL_USUARIO = $resultado['correo'];
               }else {
                 $model->TSR_ID = 3;
                 $model->REC_EMAIL_USUARIO = $resultado['correo'];
               }

           }

           $model->save();



        $model->files = UploadedFile::getInstances($model,'files');
         if($model->files ){
           $contador = count($model->files);

             for ($i=1; $i <=$contador ; $i++) {
               $adjunto = new Adjuntos();
               $name = 'Adjunto Solicitud ' . $model->REC_NUMERO . $model->REC_FECHA . '(' . $i . ')';
               //funcion que guarda el adjunto
               $model->files[$i-1]->saveAs('uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension);
               //Guardar la URL en la tabla Adjuntos
               $adjunto->REC_NUMERO = $model->REC_NUMERO;
               $adjunto->ADJ_TIPO = 'Reclamo-Sugerencia';
               $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension;
               $adjunto->save();
             }

         }

          return $this->redirect(['view', 'id' => $model->REC_NUMERO]);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }
/*************************END CREACION********************************/

/*********************CREATE FORMULARIO EN BLANCO**********************/

  public function actionCreateblank()
  {
    $model = new ReclamoSugerencia();
    //validacion ajax
    if(Yii::$app->request->isAjax && $model->load($_POST))
    {
      Yii::$app->response->format = 'json';
      return \yii\widgets\ActiveForm::validate($model);
    }
    if ($model->load(Yii::$app->request->post())){
      $model->REC_FECHA = date('Y-m-d');
      $model->REC_HORA = date('H:i:s');
      //funcion que trae el reclamo anterior
      $query = new Query;
      $query->select ('REC_NUMERO')
          ->from('RECLAMO_SUGERENCIA')
          ->where('YEAR(REC_FECHA) = DATEPART(yyyy,getDate())')
          ->orderBy('REC_NUMERO DESC')
          ->limit('1');
     //funcion que asigna el numero de la solicitud
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
      $model->save();


      $model->files = UploadedFile::getInstances($model,'files');
      if($model->files ){
        $contador = count($model->files);

        for ($i=1; $i <=$contador ; $i++) {
          $adjunto = new Adjuntos();
          $name = 'Adjunto Solicitud ' . $model->REC_NUMERO . $model->REC_FECHA . '(' . $i . ')';
          //funcion que guarda el adjunto
          $model->files[$i-1]->saveAs('uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension);
          //Guardar la URL en la tabla Adjuntos
          $adjunto->REC_NUMERO = $model->REC_NUMERO;
          $adjunto->ADJ_TIPO = 'Reclamo-Sugerencia';
          $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension;
          $adjunto->save();
        }

    }

     return $this->redirect(['view', 'id' => $model->REC_NUMERO]);

    }else {
        return $this->render('createblank', [
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
/******************ACTUALIZAR FORMULARIO RS***************/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //condicion para que ejecute ajax
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }

        $adj_existentes = new Query;
        $adj_existentes->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
        $adj_existentes = $adj_existentes->All();
        $count_existentes = count($adj_existentes);
        $max = 6 - $count_existentes;


        if ($model->load(Yii::$app->request->post()) && $model->USU_RUT == Yii::$app->user->identity->rut) {
          $model->REC_FECHA = date('Y-m-d');
          $model->REC_HORA = date('H:i:s');

          /*
          //Instancia para el adjunto SIMPLE
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
        */
           $model->files = UploadedFile::getInstances($model,'files');
           $contador = count($model->files);
           $max = $max - $contador - $count_existentes;
           if ($max>0) {
             for ($i=1; $i <=$max ; $i++) {
               $adjunto = new Adjuntos();
               $name = 'Adjunto Solicitud ' . $model->REC_NUMERO . $model->REC_FECHA . '(' . $i . ')';
               //funcion que guarda el adjunto
               $model->files[$i-1]->saveAs('uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension);
               //Guardar la URL en la tabla Adjuntos
               $adjunto->REC_NUMERO = $model->REC_NUMERO;
               $adjunto->ADJ_TIPO = 'Reclamo-Sugerencia';
               $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension;
               $adjunto->save();
             }
            }

          return $this->redirect(['view', 'id' => $model->REC_NUMERO]);

        }elseif($model->USU_RUT == Yii::$app->user->identity->rut) {
            return $this->render('update', [
                'model' => $model,
                'contador'=>$count_existentes,
                'max'=> $max,
            ]);
        }else {
            return $this->goBack();
      }
    }

    /**
     * Deletes an existing ReclamoSugerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
/*************************ELIMINAR RECLAMO SUGERENCIA*************************/
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
      $query = $query->All();
      $contador = count($query);

      if(Yii::$app->request->post() && $model->USU_RUT == Yii::$app->user->identity->rut && $model->ERS_ID == 1 ){

        if ($contador>0){
            for ($i=0; $i<$contador ; $i++) {
              $adjunto = new Adjuntos();
              $adjunto = $adjunto->findOne($query[$i]);
              unlink($adjunto->ADJ_URL);
              $adjunto = $adjunto->delete($query[$i]);
            }

        }
          $this->findModel($id)->delete();
          return $this->redirect(['index']);
        }
        return $this->goBack();

    }


/*******ENVIAR RECLAMO Y SUGERENCIA***************************/
    public function actionSend($id){

        $model = $this->findModel($id);

        if(Yii::$app->user->identity->rut == $model->USU_RUT)
        {
         $model->REC_FECHA = date('Y-m-d');
         $model->REC_HORA = date('H:i:s');
         $model->ERS_ID = 2;
         $motivo = $model->REC_MOTIVO;
         $model->REC_MOTIVO = $motivo;
         $model->save();


         Yii::$app->mailer->compose()
                  ->setFrom('viceaparedes@gmail.com')
                  ->setTo('vicea@alumnos.ubiobio.cl')//cambiar al correo del usuario, temporalmente es el mio
                  ->setSubject('Envío de Reclamo y Sugerencia')
                  ->setTextBody('probando el envío de correos')
                  ->send();
          
         //instancia para crear el Historial;
         $historial = new HistorialEstados();
         $historial->REC_NUMERO = $model->REC_NUMERO;
         $historial->ERS_ID = $model->ERS_ID;
         $historial->USU_RUT = $model->USU_RUT;
         $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
         if($model->TRS_ID == 1){
             $historial->HES_COMENTARIO = "El usuario ". $model->REC_NOMBRE_USUARIO . " ha ingresado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;

         }elseif($model->TRS_ID == 2){
                 $historial->HES_COMENTARIO = "El usuario ". $model->REC_NOMBRE_USUARIO . " ha ingresado la Sugerencia Nº ". $historial->REC_NUMERO .  " el día ". $historial->HES_FECHA_HORA;
           }else {
                $historial->HES_COMENTARIO = "El usuario ". $model->REC_NOMBRE_USUARIO . " ha ingresado la Solicitud Nº ". $historial->REC_NUMERO .  " el día ". $historial->HES_FECHA_HORA;
           }
           $historial->save();

           return $this->redirect(['view', 'id' => $model->REC_NUMERO]);
         }
         return $this->goBack();
    }

/* funcion que evalua el reclamo/sugerencia, autorizandola o rechazandola*/
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);
        $solucion = new SolucionReclamoSugerencia();

        $query = new Query;
        $query->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
        $query = $query->All();
        if ($query) {
          $contador = count($query);
        }else {
          $contador = NULL;
        }

        if(Yii::$app->request->isAjax && $solucion->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }
        //cambiar sp a uno que traiga a JDNYC.
        $rut = Yii::$app->user->identity->rut;
        $sp = "ubb..sp_web_identificacion $rut";
        $resultado = Yii::$app->dbubb->createCommand($sp)->queryOne();

        //modificar el if cuando se tenga el sp que verifique el cargo del administrativo
        if ($solucion->load(Yii::$app->request->post())  && Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO')
        {
          $solucion->ESR_ID = 1;
          $solucion->REC_NUMERO = $model->REC_NUMERO;
          $solucion->SRS_FECHA_ENVIO= date('Y-m-d');
          $solucion->USU_RUT = Yii::$app->user->identity->rut;
          $solucion->SRS_NOMBRE = $resultado['nombres'] . ' '. $resultado['paterno'] . ' ' . $resultado['materno'];

          //Autorizar o rechazar el Reclamo o Sugerencia
          $historial = new HistorialEstados();
          $solucion->save();

        if($solucion->SRS_VISTO_BUENO == 'Autorizado'){

              $model->ERS_ID = 3;
              $motivo = $model->REC_MOTIVO;
              $model->REC_MOTIVO = $motivo;
              $model->save();

              //insertar en el historial la aprobacion
              $historial->REC_NUMERO = $model->REC_NUMERO;
              $historial->ERS_ID = $model->ERS_ID;
              $historial->USU_RUT = $solucion->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $solucion->SRS_NOMBRE . " ha Aprobado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
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
              $historial->HES_COMENTARIO = "El usuario ". $solucion->SRS_NOMBRE . " ha Rechazado el Reclamo Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
              $historial->save();
            }
          //  $solucion->save();
          if(Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO')
          {
            return $this->redirect(['/solucion-reclamo-sugerencia/view', 'id' => $solucion->SRS_ID]);
          }else {
            return $this->redirect(['/solucion-reclamo-sugerencia/view2', 'id' => $solucion->SRS_ID]);
          }

        } else {
          //modificar a futuro
            if($model->ERS_ID != 2 || Yii::$app->user->identity->tipo_usuario != 'ADMINISTRATIVO'){
              //soucion parche
              return $this->goBack();
            }else {
              return $this->render('evaluate', [
                  'model' => $model,
                  'solucion'=>$solucion,
                  'contador'=>$contador,
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
