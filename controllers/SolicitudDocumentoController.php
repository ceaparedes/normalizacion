<?php

namespace app\controllers;

use Yii;
//use models
use app\models\SolicitudDocumento;
use app\models\SolicitudDocumentoSearch;
use app\models\docs;
use app\models\HistorialSolicitud;
use app\models\Adjuntos;
use app\models\DerivacionSolicitudDocumento;
use app\models\Documento;
use app\models\DetalleCambiosSolicitud;
use app\models\BorradorDocumento;
//use Yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\web\UploadedFile;


/**
 * SolicitudDocumentoController implements the CRUD actions for SolicitudDocumento model.
 */

 /*
 **Estados de Solicitud Documento**
 1.-Guardado
 2.-Enviado Por el usuario
 3.-Aprobado Por Jefe Directo
 4.-Rechazado por Jefe Directo
 5.-Aprobado por Normalizacion
 6.-Rechazado por Normalizacion
 7.-Derivado
 8.-Cerrado
 9.-Eliminado

**pueden surgir cambios
 */
class SolicitudDocumentoController extends Controller
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
     * Lists all SolicitudDocumento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolicitudDocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SolicitudDocumento model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $query = new Query; // query para traer el archivo adjunto (en caso de que exista)
      $doc = new Documento();
      $doc = $doc->findOne($model->DOC_CODIGO);

      $cambios = new DetalleCambiosSolicitud();
      $cquery = new Query; // instancia query para traer los cambios propuestos
      /*cquery start*/
      $cquery->select ('DCS_ID')
          ->from('DETALLE_CAMBIOS_SOLICITUD')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $cquery = $cquery->one();
      $cambios = $cambios->findOne($cquery);
      /*cquery end*/

      $dquery = new Query; //instancia query para traer la derviacion hecha.

      /*dquery start */
      $dquery->select ('DSD_ID')
          ->from('DERIVACION_SOLICITUD_DOCUMENTO')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $dquery = $dquery->one();
      if($dquery){
        $derivacion = new DerivacionSolicitudDocumento();
      $derivacion = $derivacion->findOne($dquery);
    }else{
      $derivacion = NULL;
    }/*dquery end*/

      //buscar el adjunto según el numero del reclamo
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $query = $query->one();
      //si existe el reclamo crea la instancia, sino deja la variable null
      if ($query){
        $adjunto = new Adjuntos();
        $adjunto = $adjunto->findOne($query);
      }else{
        $adjunto = null;
      }
      $borquery = new Query;
      $borquery->select ('BDO_ID')
          ->from('BORRADOR_DOCUMENTO')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $borquery = $borquery->one();
      if ($borquery) {
        $borrador = new BorradorDocumento();
        $borrador = $borrador->findOne($borquery);

      }else {
        $borrador = NULL;
      }
        return $this->render('view', [
            'model' => $model,
            'adjunto'=> $adjunto,
            'doc' => $doc,
            'cambios'=>$cambios,
            'derivacion'=>$derivacion,
            'borrador'=>$borrador,
        ]);
    }

    /**
     * Creates a new SolicitudDocumento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SolicitudDocumento();

        $cambios = new DetalleCambiosSolicitud();
        //validacion ajax
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $cambios->load(Yii::$app->request->post())) {

          $model->SOL_FECHA = date('Y-m-d');
          //Busca la Ultima Solicitud para analizarla
          $query = new Query;
          $query->select ('SOL_ID')
              ->from('SOLICITUD_DOCUMENTO')
              ->where('YEAR(SOL_FECHA) = DATEPART(yyyy,getDate())')
              ->orderBy('SOL_ID DESC')
              ->limit('1');
          $rows = $query->one();

          $current_year = date('Y');
          //condicion que genera la ID de la Solicitud
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
          $model->SOL_ID = $last_id;
          $model->ESO_ID = 1;

          //Instancia para el adjunto
          $name = 'solicitud ' . $model->SOL_ID . ' '. $model->SOL_FECHA . ' ' . date('H i');
          $model->file = UploadedFile::getInstance($model,'file');


          $model->save();
          $cambios->SOL_ID = $model->SOL_ID;
          $cambios->save();

          //si el archivo no es null, entonces lo guarda y guarda el adjunto en la bd.
           if ($model->file != null){
          $model->file->saveAs('uploads/solicitud-documento/Adjunto '. $name . '.' .$model->file->extension);
          //guardar la ruta en la bd
          $adjunto = new Adjuntos();
          $adjunto->SOL_ID = $model->SOL_ID;
          $adjunto->ADJ_TIPO = 'Solicitud Documento';
          $adjunto->ADJ_URL = 'uploads/solicitud-documento/Adjunto '. $name . '.' .$model->file->extension;
          $adjunto->save();
         }



            return $this->redirect(['view', 'id' => $model->SOL_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'cambios'=> $cambios,
            ]);
        }
    }



    public function actionSend($id)
    {

      $model = $this->findModel($id);

      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $query = $query->one();
      if ($query){
        $adjunto = new Adjuntos();
        $adjunto = $adjunto->findOne($query);
      }else{
        $adjunto = null;
      }

       $model->SOL_FECHA = date('Y-m-d');
       $model->SOL_HORA = date('H:i:s');
       $model->ESO_ID = 2;
       $model->save();

       //instancia para crear el Historial;
       $historial = new HistorialSolicitud();
       $historial->SOL_ID= $model->SOL_ID;
       $historial->ESO_ID = $model->ESO_ID;
       $historial->USU_RUT = $model->USU_RUT;
       $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

       $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado la solicitud  Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;

       $historial->save();

         return $this->redirect(['view', 'id' => $model->SOL_ID]);

    }

    /**
     * Updates an existing SolicitudDocumento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $docs = new docs();

        $query = new Query;
        $query->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
            ->limit('1');
        $query = $query->one();
        if ($query){
          $adjunto = new Adjuntos();
          $adjunto = $adjunto->findOne($query);
        }else{
          $adjunto = null;
        }

        //condicion para que se ejecute ajax
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) ) {
          $model->SOL_FECHA = date('Y-m-d');
          $model->SOL_HORA = date('H:i:s');
          //Instancia para el adjunto
          $name = 'solicitud ' . $model->SOL_ID . ' '. $model->SOL_FECHA . ' ' . date('H i');
          $model->file = UploadedFile::getInstance($model,'file');
          $model->save();
          if ($model->file != null){
         $model->file->saveAs('uploads/solicitud-documento/Adjunto '. $name . '.' .$model->file->extension);
         //guardar la ruta en la bd
         $adjunto = new Adjuntos();
         $adjunto->SOL_ID = $model->SOL_ID;
         $adjunto->ADJ_TIPO = 'Solicitud Documento';
         $adjunto->ADJ_URL = 'uploads/solicitud-documento/Adjunto '. $name . '.' .$model->file->extension;
         $adjunto->save();
        }

            return $this->redirect(['view', 'id' => $model->SOL_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,


            ]);
        }
    }

    /**
     * Deletes an existing SolicitudDocumento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);


      $adjunto = new Adjuntos();
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
      $query = $query->one();
      if ($query){
          $adjunto = $adjunto->findOne($query);
          $adjunto = $adjunto->delete($query);
      }

      $cambios = new DetalleCambiosSolicitud();
      $cquery= new Query;
       $cquery->select ('DCS_ID')
          ->from('DETALLE_CAMBIOS_SOLICITUD')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
          if ($cquery){
              $cambios = $cambios->findOne($cquery);
              $cambios = $cambios->delete($cquery);
          }

      if($model->ESO_ID == 1){
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
      }


    }



    public function actionEvaluate($id)
    {

      $model = $this->findModel($id);

      $doc = new Documento();
      $doc = $doc->findOne($model->DOC_CODIGO);

      /*query para hallar los cambios propuestos*/
      $cquery= new Query;
       $cquery->select ('DCS_ID')
          ->from('DETALLE_CAMBIOS_SOLICITUD')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
        if($cquery){
          $cambios = new DetalleCambiosSolicitud();
          $cambios = $cambios->findOne($cquery);
        }else {
          $cambios= NULL;
        }
        /*end query*/


      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return \yii\widgets\ActiveForm::validate($model);
      }

      if ($model->load(Yii::$app->request->post()))
      {
        //Aprobar o rechazar el Reclamo o Sugerencia
        $historial = new HistorialSolicitud();
      //if($model->SOL_VISTO_BUENO == 'Aprobado' && 'insertar rol aca')
      if($model->SOL_VISTO_BUENO == 'Aprobado'){

            $model->ESO_ID = 5;//cambiar a 3 cuando los roles esten implementados
            $model->save();

            //insertar en el historial la aprobacion
            $historial->SOL_ID = $model->SOL_ID;
            $historial->ESO_ID = $model->ESO_ID;
            $historial->USU_RUT = $model->USU_RUT;
            $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
            $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;
            $historial->save();


        }//elseif($model->SOL_VISTO_BUENO == 'Rechazado' && 'inserte Rol aqui')
        elseif($model->SOL_VISTO_BUENO == 'Rechazado'){
            $model->ESO_ID = 4;
            $model->save();
            //insertar en e historial el rechazo
            $historial->SOL_ID = $model->SOL_ID;
            $historial->ESO_ID = $model->ESO_ID;
            $historial->USU_RUT = $model->USU_RUT;
            $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
            $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA . '. El caso queda cerrado.';
            $historial->save();
          }
          /*
          elseif ($model->SOL_VISTO_BUENO_NYC == 'Aprobado' && 'inserte rol aqui') {
              $model->ESO_ID = 5;
              $model->save();

              //insertar en el historial la aprobacion
              $historial->SOL_ID = $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;
              $historial->save();

              return $this->redirect(['/derivate']);

          }elseif($model->SOL_VISTO_BUENO_NYC == 'Rechazado' && 'inserte rol aqui'){

          $model->ESO_ID = 6;
          $model->save();

          //insertar en el historial la aprobacion
          $historial->SOL_ID = $model->SOL_ID;
          $historial->ESO_ID = $model->ESO_ID;
          $historial->USU_RUT = $model->USU_RUT;
          $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
          $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA . 'cerrando el caso';
          $historial->save();



        }*/

        return $this->redirect(['view', 'id' => $model->SOL_ID]);



      } else {
          if($model->ESO_ID != 2){
            //soucion parche
            return $this->redirect(['/index']);
          }else {
            return $this->render('evaluate', [
                'model' => $model,
                'cambios' =>$cambios,
                'doc'=>$doc,
            ]);
          }

      }


    }


/* action que evalua la solicitud de parte del departamento de Normalizacion*/
    public function actionNevaluate($id)
    {
      $model = $this->findModel($id);

      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return \yii\widgets\ActiveForm::validate($model);
      }

      if ($model->load(Yii::$app->request->post()))
      {
        //Aprobar o rechazar el Reclamo o Sugerencia
        $historial = new HistorialSolicitud();
      if($model->SOL_VISTO_BUENO == 'Aprobado'){

        $model->ESO_ID = 5;
        $model->save();
        //insertar en el historial la aprobacion
        $historial->SOL_ID = $model->SOL_ID;
        $historial->ESO_ID = $model->ESO_ID;
        $historial->USU_RUT = $model->USU_RUT;
        $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
        $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;
        $historial->save();
      }else {

        $model->ESO_ID = 6;
        $model->save();
        //insertar en e historial el rechazo
        $historial->SOL_ID = $model->SOL_ID;
        $historial->ESO_ID = $model->ESO_ID;
        $historial->USU_RUT = $model->USU_RUT;
        $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
        $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado la Solicitud Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;
        $historial->save();
      }
      return $this->redirect(['view', 'id' => $model->SOL_ID]);

    }else {
      return $this->render('evaluate', [
          'model' => $model,
          'docs' =>$docs,
      ]);
    }

    }

    public function actionDerivate($id){

      $model = $this->findModel($id);
      $derivacion = new DerivacionSolicitudDocumento();
      $doc = new Documento();
      $doc = $doc->findOne($model->DOC_CODIGO);

      /*query para hallar los cambios propuestos*/
      $cquery= new Query;
      $cquery->select ('DCS_ID')
          ->from('DETALLE_CAMBIOS_SOLICITUD')
          ->where('SOL_ID=:solicitud', [':solicitud' => $model->SOL_ID])
          ->limit('1');
        if($cquery){
          $cambios = new DetalleCambiosSolicitud();
          $cambios = $cambios->findOne($cquery);
        }else {
          $cambios= NULL;
        }
        /*end query*/


      //validacion ajax
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return \yii\widgets\ActiveForm::validate($model);
      }

      if ($derivacion->load(Yii::$app->request->post()) )
      {

        $derivacion->DSD_FECHA_DERIVACION = date('Y-m-d');
        $derivacion->SOL_ID= $model->SOL_ID;
        $derivacion->EDS_ID = 1;

        $derivacion->save();

        $model->ESO_ID = 7;
        $model->save();


        //Historial
        /*
        $historial = new HistorialSolicitud();
        $historial->SOL_ID= $model->SOL_ID;
        $historial->ESO_ID = $model->ESO_ID;
        $historial->USU_RUT = $model->USU_RUT;
        $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');
        $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Derivado la solucitud Nº ". $model->SOL_ID ." a la unidad  ".$derivacion->DSD_UNIDAD . " el día ". $historial->HSO_FECHA_HORA;
        $historial->save();*/

        return $this->redirect(['view', 'id' => $model->SOL_ID]);

      }else{
        return $this->render('derivate', [
            'model' => $model,
            'derivacion' => $derivacion,
            'cambios' => $cambios,
            'doc'=>$doc,
            ]);
          }

    }
    public function actionEliminar($id){
      $model = $this->findModel($id);
      $version = new VersionDocumento();
      $query = new Query;
      $query->select('VER_ID')
            ->from('VERSION_DOCUMENTO')
            ->where('DOC_CODIGO=:documento', [':documento' => $model->DOC_CODIGO])
            ->orderBy('VER_ID DESC')
            ->limit('1');

      if($model->load(Yii::$app->request->post()) ){

        if($model->TAS_ID == 5 || $model->TAS_ID == 6){
          
        }
      }

    }

    /**
     * Finds the SolicitudDocumento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SolicitudDocumento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SolicitudDocumento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
