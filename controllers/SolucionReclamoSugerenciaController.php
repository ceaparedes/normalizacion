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
use app\models\PersonalSearch;

//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\db\QueryTrait;
use yii\filters\AccessControl;
/**
 * SolucionReclamoSugerenciaController implements the CRUD actions for SolucionReclamoSugerencia model.
 */
class SolucionReclamoSugerenciaController extends Controller
{
    public function behaviors()
    {
        return [
          'access'=>[
              'class'=>AccessControl::classname(),
              'only'=>['derivate','evaluate','resultados','view','index'],
              'rules'=>[
                [
                  'allow'=>true,
                  'actions' =>['derivate','view','resultados','index'],
                  'roles'=>['@'],//cambiar al rol a JDNYC
                ],
                [
                  'allow'=>true,
                  'actions' =>['evaluate','view'],
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
      //traer los datos del reclamo a la vista
      $reclamo = new ReclamoSugerencia();
      $reclamo = $reclamo->findOne($model->REC_NUMERO);

      //query de comprobacion de existencia de archivos Adjuntos;
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Reclamo-Sugerencia'", [':reclamo' => $model->REC_NUMERO]);
      $query = $query->All();
      if ($query){
        $contador = count($query);
      }else{
        $contador = null;
      }
        if(Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO')
        {
          return $this->render('view', [
            'model' => $model,
            'contador' =>$contador,
            'reclamo' =>$reclamo,
        ]);
      }else {
        return $this->render('view2', [
          'model' => $model,
          'contador' =>$contador,
          'reclamo' =>$reclamo,
      ]);

      }
    }

    /**
     * Deletes an existing SolucionReclamoSugerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      if($model->ESO_ID == 1){
        $model->ESO_ID = 6;

        $model->save();
        return $this->redirect(['index']);
      }
        return $this->redirect(['site/index']);
    }

/********************EVALUAR SOLUCION ENTREGADA*************************/
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);

        $reclamo = new ReclamoSugerencia();
        $reclamo = $reclamo->findOne($model->REC_NUMERO);
        //Proceso para traer la respuesta del afectado al solicitante
        $query = new Query;
        $query->select ('DRS_ID')
            ->from('DERIVACION_RECLAMO_SUGERENCIA')
            ->where('SRS_ID=:solucion', [':solucion' => $model->SRS_ID]);
        $query = $query->All();
        if($query){
          $derivaciones = count($query);

      }else {
        $derivaciones = NULL;
      }

      $sac_sap_rors = new Query;
      $sac_sap_rors->select ('ADJ_ID')
          ->from('ADJUNTOS')
            ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Respuesta-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
      $sac_sap_rors = $sac_sap_rors->All();
      if($sac_sap_rors){
        $count_adj_respuestas = count($sac_sap_rors);
      }else {
        $count_adj_respuestas = NULL;
      }

        if ($reclamo->load(Yii::$app->request->post()) || $model->load(Yii::$app->request->post()) )
        {

          $model->SRS_FECHA_RESPUESTA = date('Y-m-d');
          $historial = new HistorialEstados();
          $reclamo->save();//esto tiene que ir aca si o si
          $model->save();

          //cambiar a JDNYC
          if($reclamo->REC_VISTO_BUENO == 'Autorizado' && Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO' && $reclamo->ERS_ID == 6){

              $model->ESR_ID = 2;
              $reclamo->ERS_ID = 7;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA . "  a la espera de la evaluacion del usuario";
              $historial->save();
              //end historial
          }elseif($reclamo->REC_VISTO_BUENO == 'Rechazado' && Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO'
          && $reclamo->ERS_ID ==6){
              $model->ESR_ID = 3;
              $reclamo->ERS_ID = 5;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA .'. '. ' derivandose nuevamente a el/los Responsable(s).';
              $historial->save();
              //end Historial
          }elseif ($model->visto_bueno == 'Autorizado' && Yii::$app->user->identity->rut == $reclamo->USU_RUT ) {

              $model->ESR_ID = 4;
              $reclamo->ERS_ID = 11;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA . "  derivandose nuevamente a el/los Responsable(s).";
              $historial->save();
          }elseif ($model->visto_bueno == 'Rechazado' && Yii::$app->user->identity->rut == $reclamo->USU_RUT) {
              $model->ESR_ID = 5;
              $reclamo->ERS_ID = 5;
              $reclamo->save();
              $model->save();
              //historial
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Aprobado la Solucion Entregada al formulario Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA . "  cerrando el caso.";
              $historial->save();

          }

          return $this->redirect(['view', 'id' => $model->SRS_ID]);
        }else {

          //cambiar a JDNYC
          if(Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO' && $reclamo->ERS_ID == 6){
            return $this->render('evaluate', [
                'model' => $model,
                'reclamo'=>$reclamo,
                'derivaciones'=>$derivaciones,
                'count_adj_respuestas' => $count_adj_respuestas,
            ]);
          }elseif (Yii::$app->user->identity->rut == $reclamo->USU_RUT && $reclamo->ERS_ID == 7) {
            return $this->render('userevaluate', [
                'model' => $model,
                'reclamo'=>$reclamo,
                'derivaciones'=>$derivaciones,
                //ver si pasar los sac-sap de respuesta aca
            ]);
          }
        }


    }

    /*  public function actionResultados($id){
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
        } */

/*********************DERIVAR RECLAMO SUGERENCIA***************************/
        public function actionDerivate($id){

          $model = $this->findModel($id);
          //instancias necesarias para buscar personal

          $searchModel = new PersonalSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          //inicializacion de la derivacion
          $derivacion = new DerivacionReclamoSugerencia();

          //traer los datos del reclamo en cuestion
          $reclamo = new ReclamoSugerencia();
          $reclamo = $reclamo->findOne($model->REC_NUMERO);


          if(Yii::$app->request->isAjax && $model->load($_POST))
          {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
          }

          //modificar el if cuando tenga el los datos de normalzacion
          if ($derivacion->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())   && Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO')
          {

            $usuarios = explode('-',$derivacion->hidden);

            $count_usuarios = count($usuarios);


            for ($i=1; $i <$count_usuarios ; $i++) {

              $rut = $usuarios[$i];
              //cambiar al sp que corresponda
              $sp = "ubb..sp_web_identificacion $rut";
              $resultado = Yii::$app->dbubb->createCommand($sp)->queryOne();

              $derivacion->DRS_FECHA_DERIVACION = date('Y-m-d');
              $derivacion->SRS_ID = $model->SRS_ID;
              $derivacion->EDR_ID = 1;
              $derivacion->USU_RUT = $rut;
              $derivacion->DRS_NOMBRE = $resultado['nombres'] . ' ' . $resultado['paterno'] . ' ' . $resultado['materno'];
              //echo $rut . '<br>';
              $derivacion->DRS_CARGO = 'prueba cargo';
              $derivacion->DRS_UNIDAD = 'prueba Unidad';//cambiar cuando tenga el sp

              if($derivacion->save())
              $derivacion = new DerivacionReclamoSugerencia();

              $rut = NULL;

            }
            $model->save();
            if($reclamo->TRS_ID != 3)
            {
              $reclamo->ERS_ID = 5;
              $reclamo->save();
              $model->save();
              //Historial
              $historial = new HistorialEstados();
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $model->SRS_NOMBRE . " ha Derivado la solucitud Nº ". $historial->REC_NUMERO ." a la unidad  ".$derivacion->DRS_UNIDAD . " el día ". $historial->HES_FECHA_HORA;
              $historial->save();
            }else {
              $reclamo->ERS_ID = 11;
              $reclamo->save();
              $model->save();
              //historial
              $historial = new HistorialEstados();
              $historial->REC_NUMERO = $reclamo->REC_NUMERO;
              $historial->ERS_ID = $reclamo->ERS_ID;
              $historial->USU_RUT = $reclamo->USU_RUT;
              $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
              $historial->HES_COMENTARIO = "El usuario ". $model->SRS_NOMBRE . " ha Derivado la solucitud Nº ". $historial->REC_NUMERO ." a la unidad  ".$derivacion->DRS_UNIDAD . " el día ". $historial->HES_FECHA_HORA . ' Cerrando el Caso';
              $historial->save();
            }


            $date = date('Y-m-d');
            $derivacion->files = UploadedFile::getInstances($derivacion,'files');
            if($derivacion->files ){
              $contador = count($derivacion->files);

                for ($i=1; $i<=$contador; $i++) {
                  $adjunto = new Adjuntos();
                  $name = 'Adjunto Derivacion ' . '(' . $i . ')'. ' a la Solicitud ' .  $reclamo->REC_NUMERO . $date ;
                  //funcion que guarda el adjunto
                  $derivacion->files[$i-1]->saveAs('uploads/reclamo-sugerencia/' . $name . '.' . $derivacion->files[$i-1]->extension);
                  //Guardar la URL en la tabla Adjuntos
                  $adjunto->REC_NUMERO = $reclamo->REC_NUMERO;

                  $adjunto->ADJ_TIPO = 'Derivacion-Reclamo-Sugerencia';
                  $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/' . $name . '.' . $derivacion->files[$i-1]->extension;
                  $adjunto->save();
                }


            }

            //redirige al index, cambiar cuando
            return $this->redirect(['derivacion-reclamo-sugerencia/index']);

          }else{
            return $this->render('derivate', [
                'model' => $model,
                'derivacion' => $derivacion,
                'reclamo'=>$reclamo,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
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
