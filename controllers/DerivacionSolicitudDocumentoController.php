<?php

namespace app\controllers;
//use tii models
use Yii;
use app\models\DerivacionSolicitudDocumento;
use app\models\DerivacionSolicitudDocumentoSearch;
use app\models\SolicitudDocumento;
use app\models\Documento;
use app\models\DetalleCambiosSolicitud;
use app\models\BorradorDocumento;
use app\models\Adjuntos;

use app\models\HistorialSolicitud;
//use yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


/**
 * DerivacionSolicitudDocumentoController implements the CRUD actions for DerivacionSolicitudDocumento model.
 */
class DerivacionSolicitudDocumentoController extends Controller
{
    public function behaviors()
    {
        return [
          'access'=>[
            'class'=>AccessControl::classname(),
            'only'=>['view','borrador','index'],
            'rules'=>[
              [
                'allow'=>true,
                'actions' =>['view','borrador'],
                'roles'=>['@'],//cambiar al rol a Funcionario DNYC
              ],
              [
                'allow'=>true,
                'actions' =>['view','borrador'],
                'roles'=>['@'],//cambiar al rol a Funcionario DNYC
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
     * Lists all DerivacionSolicitudDocumento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DerivacionSolicitudDocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DerivacionSolicitudDocumento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $solicitud = new SolicitudDocumento();
      $solicitud = $solicitud->findOne($model->SOL_ID);

      $docquery = new Query;
      $docquery->select ('DOC_CODIGO')
            ->from('DOCUMENTO')
            ->where('DOC_CODIGO=:doc', [':doc' => $solicitud->DOC_CODIGO])
            ->limit('1');
        $docquery = $docquery->one();
        if($docquery){
        $documento = new Documento();
        $documento = $documento->findOne($docquery);
      }else {
        $documento = NULL;
      }


      $cquery = new Query();
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

        return $this->render('view', [
            'model' => $model,
            'cambios'=>$cambios,
            'docuemnto'=>$documento,
            'solicitud'=> $solicitud,
        ]);
    }

    /**
     * Creates a new DerivacionSolicitudDocumento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBorrador($id)
    {
        $model = $this->findModel($id);
        $borrador = new BorradorDocumento();
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

        if ($model->load(Yii::$app->request->post()) &&    $borrador->load(Yii::$app->request->post()) &&
        $borrador->load(Yii::$app->request->post()) ) {

          $borrador->BDO_FECHA_ENVIO = date('Y-m-d');
          $model->DSD_FECHA_RESPUESTA = date('Y-m-d');
          $model->EDS_ID = 2;
          $borrador->EBD_ID = 2;
          $borrador->SOL_ID= $model->SOL_ID;
          //instancia para generar el Nombre del Documento
          $borrador->file = UploadedFile::getInstance($borrador,'file');

          $model->save();
          $borrador->save();
          $solicitud->ESO_ID = 8;
          $solicitud->save();
          //si el archivo no es null, entonces lo guarda y guarda el adjunto en la bd.
           if ($borrador->file != null){
          $borrador->file->saveAs('uploads/borrador-documento/'. $borrador->file->baseName . '.' .$borrador->file->extension);
          //guardar la ruta en la bd
          $adjunto = new Adjuntos();

          $adjunto->BDO_ID = $borrador->BDO_ID;
          $adjunto->ADJ_TIPO = 'Borrador Documento';
          $adjunto->ADJ_URL = 'uploads/borrador-documento/'. $borrador->file->baseName . '.' .$borrador->file->extension;
          $adjunto->save();
         }

        /* //instancia para crear el Historial;
         $historial = new HistorialSolicitud();
         $historial->SOL_ID= $solicitud->SOL_ID;
         $historial->ESO_ID = $solicitud->ESO_ID;
         $historial->USU_RUT = $model->USU_RUT;
         $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

         $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha subido el borrador con los cambios requeridos en la Solicitud  Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;

         $historial->save();*/

            return $this->redirect(['view', 'id' => $model->DSD_ID]);
        } else {
            return $this->render('borrador', [
              'model' => $model,
              'borrador'=>$borrador,
              'cambios' =>$cambios,
              'solicitud'=>$solicitud,
            ]);
        }
    }

    /**
     * Updates an existing DerivacionSolicitudDocumento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->DSD_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DerivacionSolicitudDocumento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DerivacionSolicitudDocumento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DerivacionSolicitudDocumento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DerivacionSolicitudDocumento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
