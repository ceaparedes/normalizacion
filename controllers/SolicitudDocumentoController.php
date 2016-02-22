<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudDocumento;
use app\models\SolicitudDocumentoSearch;
use app\models\docs;
//use Yii tools
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryTrait;
use yii\web\UploadedFile;
use kartik\widgets\DepDrop;

/**
 * SolicitudDocumentoController implements the CRUD actions for SolicitudDocumento model.
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        //validacion ajax
        if(Yii::$app->request->isAjax && $model->load($_POST))
        {
          Yii::$app->response->format = 'json';
          return \yii\widgets\ActiveForm::validate($model);
        }

        $docs = new docs();


        if ($model->load(Yii::$app->request->post())) {

          $model->SOL_FECHA = date('Y-m-d');

          $query = new Query;
          $query->select ('SOL_ID')
              ->from('SOLICITUD_DOCUMENTO')
              ->where('YEAR(REC_FECHA) = DATEPART(yyyy,getDate())')
              ->orderBy('SOL_ID DESC')
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
          $model->SOL_ID = $last_id;
          $model->ESO_ID = 1;

            $model->save();
            return $this->redirect(['view', 'id' => $model->SOL_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'docs' => $docs,
            ]);
        }
    }



    public function actionSend($id){

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
       //$model->SOL_HORA = date('H:i:s');
       $model->ESO_ID = 2;

       $model->save();

       //instancia para crear el Historial;
       $historial = new HistorialSolicitud();
       $historial->SOL_ID= $model->SOL_ID;
       $historial->ESO_ID = $model->ESO_ID;
       $historial->USU_RUT = $model->USU_RUT;
       $historial->HSO_FECHA_HORA = date('Y-m-d H:i:s');

       $historial->HSO_COMENTARIO = "El usuario ". $historial->USU_RUT . " ha ingresado la sólicitud  Nº ". $historial->SOL_ID ." el día ". $historial->HSO_FECHA_HORA;


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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    public function actionSubcat() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $cat_id = $parents[0];
            $out = self::getSubCatList($cat_id);
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}
}
