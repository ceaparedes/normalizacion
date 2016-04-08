<?php

namespace app\controllers;

use Yii;
//use models
use app\models\BorradorDocumento;
use app\models\BorradorDocumentoSearch;
use app\models\docs;
use app\models\HistorialSolicitud;
use app\models\Adjuntos;
use app\models\DerivacionSolicitudDocumento;
use app\models\Documento;
use app\models\DetalleCambiosSolicitud;
use app\models\SolicitudDocumento;
//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\filters\AccessControl;

/**
 * BorradorDocumentoController implements the CRUD actions for BorradorDocumento model.
 */
class BorradorDocumentoController extends Controller
{
    public function behaviors()
    {
        return [
          'access'=>[
            'class'=>AccessControl::classname(),
            'only'=>['view','index','evaluate'],
            'rules'=>[
              [
                'allow'=>true,
                'actions' =>['view','index','evaluate'],
                'roles'=>['@'],//cambiar al rol a JDNYC , REVISOR Y APROBADOR.
              ],
              [
                'allow'=>true,
                'actions' =>['view'],
                'roles'=>['@'],//cambiar al rol a funcionario DNYC
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
     * Lists all BorradorDocumento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BorradorDocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BorradorDocumento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $solicitud = new SolicitudDocumento();
      $solicitud = $solicitud->findOne($model->SOL_ID);

      $cquery = new Query;
      $cquery->select ('DCS_ID')
            ->from('DETALLE_CAMBIOS_SOLICITUD')
            ->where('SOL_ID=:cambios', [':cambios' => $model->SOL_ID])
            ->limit('1');
        $cquery = $cquery->one();

        if ($cquery) {
          $cambios = new DetalleCambiosSolicitud();
          $cambios = $cambios->findOne($cquery);
        }else {
          $cambios = NULL;
        }

        $query = new Query;
        $query->select ('ADJ_ID')
              ->from('ADJUNTOS')
              ->where('BDO_ID=:borrador', [':borrador' => $model->BDO_ID])
              ->limit('1');
          $query = $query->one();
          if($query){
          $adjunto = new Adjuntos();
          $adjunto = $adjunto->findOne($query);
        }else {
          $adjunto = NULL;
        }


        return $this->render('view', [
            'model' => $model,
            'solicitud'=>$solicitud,
            'cambios'=>$cambios,
            'adjunto'=>$adjunto,

        ]);
    }

    /**
     * Creates a new BorradorDocumento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new BorradorDocumento();
        $derivacion = new DerivacionSolicitudDocumento();
        $derivacion = $derivacion->findOne($id);


        if ($model->load(Yii::$app->request->post()) ) {

          $model->BDO_FECHA_ENVIO = date('Y-m-d');
          //instancia para generar el Nombre del Documento
          $model->file = UploadedFile::getInstance($model,'file');


          $model->save();
          //si el archivo no es null, entonces lo guarda y guarda el adjunto en la bd.
           if ($model->file != null){
             $name = 'borrador Solicitud '. $model->SOL_ID;
          $model->file->saveAs('uploads/borrador-documento/'. $name . '.' .$model->file->extension);
          //guardar la ruta en la bd
          $adjunto = new Adjuntos();
          $adjunto->SOL_ID = $model->SOL_ID;
          $adjunto->ADJ_TIPO = 'Solicitud Documento';
          $adjunto->ADJ_URL = 'uploads/solicitud-documento/'. $name . '.' .$model->file->extension;
          $adjunto->save();
         }

            return $this->redirect(['view', 'id' => $model->BDO_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'derivacion'=>$derivacion,
            ]);
        }
    }

    /**
     * Updates an existing BorradorDocumento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->BDO_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BorradorDocumento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionEvaluate($id)
    {

      $model = $this->findModel($id);
      $solicitud = new SolicitudDocumento();
      $solicitud = $solicitud->findOne($model->SOL_ID);

      $cambios = new DetalleCambiosSolicitud();
      $cquery = new Query;
      $cquery->select ('DCS_ID')
            ->from('DETALLE_CAMBIOS_SOLICITUD')
            ->where('SOL_ID=:cambios', [':cambios' => $model->SOL_ID])
            ->limit('1');
        $cquery = $cquery->one();

        if ($cquery) {
          $cambios = new DetalleCambiosSolicitud();
          $cambios = $cambios->findOne($cquery);
        }else {
          $cambios = NULL;
        }

        $query = new Query;
        $query->select ('ADJ_ID')
              ->from('ADJUNTOS')
              ->where('BDO_ID=:borrador', [':borrador' => $model->BDO_ID])
              ->limit('1');
          $query = $query->one();
          if($query){
          $adjunto = new Adjuntos();
          $adjunto = $adjunto->findOne($query);
        }else {
          $adjunto = NULL;
        }


        $dquery = new Query;
        $dquery->select ('DSD_ID')
              ->from('DERIVACION_SOLICITUD_DOCUMENTO')
              ->where('SOL_ID=:borrador', [':borrador' => $model->SOL_ID])
              ->limit('1');
          $dquery = $dquery->one();
          if($query){
          $derivacion = new DerivacionSolicitudDocumento();
          $derivacion = $derivacion->findOne($dquery);
        }else {
          $derivacion = NULL;
        }


        if($model->load(Yii::$app->request->post()) ){

            if($model->visto_bueno_normalizacion == 'Aprobado'/*falta rol*/){
              $solicitud->ESO_ID = 9;//aprobada por Normalizacion
              $derivacion->EDS_ID = 3;
              $model->EBD_ID = 3;
              $solicitud->save();
              $derivacion->save();
              $model->save();


              $historial = new HistorialSolicitud();
              $historial->BDO_ID= $model->BDO_ID;
              $historial->ESO_ID = $solicitud->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha aprobado el Borrador requerido para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;

              $historial->save();
            }elseif($model->visto_bueno_normalizacion == 'Rechazado' /*falta rol*/) {
              $solicitud->ESO_ID = 7;//rechazada por Normalizacion
              $derivacion->EDS_ID = 1;
              $model->EBD_ID = 4;
              $solicitud->save();
              $derivacion->save();
              $model->save();

              $historial = new HistorialSolicitud();
              $historial->SOL_ID= $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado el borrador presentado para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA . '.' . 'el Borrador fue devuelto al Departamento de Normalización';

              $historial->save();

            }elseif($model->visto_bueno_revisor == 'Aprobado'){
              $solicitud->ESO_ID = 12;//Aprobado por revisor
              $derivacion->EDS_ID = 1;

              $solicitud->save();
              $derivacion->save();
              $model->save();


              $historial = new HistorialSolicitud();
              $historial->SOL_ID= $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha aprobado el Borrador requerido para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;
              $historial->save();
            }elseif ($model->visto_bueno_revisor =='Rechazado') {
              $solicitud->ESO_ID = 7;//Aprobado por revisor
              $derivacion->EDS_ID = 4;
              $model->EBD_ID = 4;
              $solicitud->save();
              $derivacion->save();
              $model->save();

              $historial = new HistorialSolicitud();
              $historial->SOL_ID= $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado el borrador presentado para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA . '.' . 'el Borrador fue devuelto al Departamento de Normalización';

              $historial->save();


            }elseif ($model->visto_bueno_aprobador == 'Aprobado') {
              $solicitud->ESO_ID = 12;//Aprobado por Aprobador
              $derivacion->EDS_ID = 1;

              $solicitud->save();
              $derivacion->save();
              $model->save();

              $historial = new HistorialSolicitud();
              $historial->SOL_ID= $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

                $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha aprobado el Borrador requerido para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;

              $historial->save();

            }elseif ($model->visto_bueno_aprobador == 'Rechazado') {
              $solicitud->ESO_ID = 7;//rechazado por Aprobador
              $derivacion->EDS_ID = 1;
              $model->EBD_ID = 4;
              $solicitud->save();
              $derivacion->save();
              $model->save();

              $historial = new HistorialSolicitud();
              $historial->SOL_ID= $model->SOL_ID;
              $historial->ESO_ID = $model->ESO_ID;
              $historial->USU_RUT = $model->USU_RUT;
              $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

              $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha Rechazado el borrador presentado para satisfacer la Solicitud   Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA . '.' . 'el Borrador fue devuelto al Departamento de Normalización';

              $historial->save();
            }



          return $this->redirect(['borrador-documento/index']);

        }else {
          return $this->render('evaluate', [
            'model' => $model,
            'cambios' =>$cambios,
            'solicitud'=>$solicitud,
            'adjunto'=>$adjunto,
          ]);


        }






    }

    /**
     * Finds the BorradorDocumento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BorradorDocumento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BorradorDocumento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
