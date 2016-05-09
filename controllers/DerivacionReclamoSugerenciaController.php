<?php

namespace app\controllers;

use Yii;
//use models
use app\models\DerivacionReclamoSugerencia;
use app\models\DerivacionReclamoSugerenciaSearch;
use app\models\SolucionReclamoSugerencia;
use app\models\HistorialEstados;
use app\models\ReclamoSugerencia;
use app\models\Adjuntos;

//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * DerivacionReclamoSugerenciaController implements the CRUD actions for DerivacionReclamoSugerencia model.
 */
class DerivacionReclamoSugerenciaController extends Controller
{
    public function behaviors()
    {
        return [
          'access'=>[
              'class'=>AccessControl::classname(),
              'only'=>['index','view'],
              'rules'=>[
                [
                  'allow'=>true,
                  'roles'=>['@'],//cambiar al rol a funcionario R.
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
        $model = $this->findModel($id);
        $solucion = new SolucionReclamoSugerencia();
        $solucion = $solucion->findOne($model->SRS_ID);
        $reclamo = new ReclamoSugerencia();
        $reclamo = $reclamo->findOne($solucion->REC_NUMERO);
        //query que trae los adjuntos presentados por el usuario
        $adj_usuarios = new Query;
        $adj_usuarios->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Reclamo-Sugerencia'", [':reclamo' => $reclamo->REC_NUMERO]);
        $adj_usuarios = $adj_usuarios->All();
        //si existe el reclamo crea la instancia, sino deja la variable null
        if ($adj_usuarios){
          $contador_adj_usuarios = count($adj_usuarios);
        }else{
          $contador_adj_usuarios = null;
        }

        //query que trae los adjuntos presentados en la derivacion
        $query = new Query;
        $query->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Derivacion-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
        $query = $query->All();
        //si existe el reclamo crea la instancia, sino deja la variable null
        if ($query){
          $contador_sac_sap = count($query);
        }else{
          $contador_sac_sap = null;
        }

        $query = new Query;
        $query->select ('ADJ_ID')
            ->from('ADJUNTOS')
            ->where("REC_NUMERO=:reclamo AND DRS_ID=:derivacion AND ADJ_TIPO = 'respuesta-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO, 'derivacion' => $model->DRS_ID]);
        $query = $query->All();
        //si existe el reclamo crea la instancia, sino deja la variable null
        if ($query){
          $contador_respuestas = count($query);
        }else{
          $contador_respuestas = null;
        }


        return $this->render('view', [
            'model' => $model,
            'reclamo'=>$reclamo,
            'solucion'=>$solucion,
            'contador_sac_sap' => $contador_sac_sap,
            'contador_respuestas' => $contador_respuestas,
            'contador_adj_usuarios' => $contador_adj_usuarios
        ]);
    }





/************************ENVIAR RESPUESTA***************/
    public function actionAnswer($id)
    {
      $model = $this->findModel($id);
      $solucion = new SolucionReclamoSugerencia();
      $solucion = $solucion->findOne($model->SRS_ID);
      //proceso para traer el reclamo correspondiente
      $reclamo = new ReclamoSugerencia();

      $reclamo = $reclamo->findOne($solucion->REC_NUMERO);
      //end proceso

      /*Query que cuenta las derivaciones realizadas*/
      $count_query = new Query;
      $count_query->select('DRS_ID')
                  ->from('DERIVACION_RECLAMO_SUGERENCIA')
                  ->where('SRS_ID=:solucion', [':solucion' => $model->SRS_ID]);
      $count_query = $count_query->All();
      $contador_derivaciones = count($count_query);

      /*Query que trae los SAC-SAP a completar*/
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Derivacion-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
      $query = $query->All();
      //si existe el reclamo crea la instancia, sino deja la variable null
      if ($query){
        $contador_sac_sap = count($query);
      }else{
        $contador_sac_sap = null;
      }


      //validacion con ajax
      if(Yii::$app->request->isAjax && $model->load($_POST))
      {
        Yii::$app->response->format = 'json';
        return \yii\widgets\ActiveForm::validate($model);
      }

      if ($model->load(Yii::$app->request->post()) && $reclamo->TRS_ID !=3 )
      {

        $historial = new HistorialEstados();

        $model->DRS_FECHA_RESPUESTA = date('Y-m-d');
        $model->EDR_ID = 2;
        $model->save();


        $model->files = UploadedFile::getInstances($model,'answer_files');
         if($model->files ){
           $contador = count($model->files);

             for ($i=1; $i <=$contador ; $i++) {
               $adjunto = new Adjuntos();
               $name = 'Adjunto Respuesta a la Solicitud ' . $reclamo->REC_NUMERO . $model->DRS_FECHA_RESPUESTA . '(' . $i . ')';
               //funcion que guarda el adjunto
               $model->files[$i-1]->saveAs('uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension);
               //Guardar la URL en la tabla Adjuntos
               $adjunto->REC_NUMERO = $reclamo->REC_NUMERO;
               $adjunto->DRS_ID = $model->DRS_ID;
               $adjunto->ADJ_TIPO = 'Respuesta-Reclamo-Sugerencia';
               $adjunto->ADJ_URL = 'uploads/reclamo-sugerencia/' . $name . '.' . $model->files[$i-1]->extension;
               $adjunto->save();
             }

         }

        //historial
        $historial->REC_NUMERO = $reclamo->REC_NUMERO;
        $historial->ERS_ID = $reclamo->ERS_ID;
        $historial->USU_RUT = $reclamo->USU_RUT;//cambiar
        $historial->HES_FECHA_HORA = date('Y-m-d H:i:s');
        $historial->HES_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Respondido a la derivación de la solicitud Nº ". $historial->REC_NUMERO ." el día ". $historial->HES_FECHA_HORA;
        $historial->save();
        //end historial

        /*query que cuenta las derivaciones realizadas.*/
        $count_respuestas = new query;
        $count_respuestas->select('DRS_ID')
                        ->from('DERIVACION_RECLAMO_SUGERENCIA')
                        ->where('SRS_ID=:solucion AND EDR_ID = 2', [':solucion' => $solucion->SRS_ID]);
        $count_respuestas = $count_respuestas->All();
        $respuestas_emitidas = count($count_respuestas);
        if($respuestas_emitidas - $contador_derivaciones == 0){
            $reclamo->ERS_ID = 7;//RESPONDIDO POR TODOS LOS USUARIOS
            $reclamo->save();
        }elseif ($contador_derivaciones - $respuestas_emitidas < $contador_derivaciones) {
          $reclamo->ERS_ID = 6;
          $reclamo->save();
        }
        return $this->redirect(['view', 'id' => $model->DRS_ID]);

      }else{
        if($model->EDR_ID == 1/*&& $model->USU_RUT == Yii::$app->user->identity->rut*/){
            return $this->render('answer', [
            'model' => $model,
            'solucion' => $solucion,
            'reclamo'=> $reclamo,
            'contador_sac_sap'=>$contador_sac_sap,
            ]);
          }else {
            return $this->goBack();
          }

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
