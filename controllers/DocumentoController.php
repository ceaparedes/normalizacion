<?php

namespace app\controllers;

use Yii;
use app\models\Documento;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DocumentoController extends Controller
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



  public function actionLists($id)
    {

        $countDocumentos = Documento::find()
                ->where(['ODO_ID' => $id])
                ->count();

        $documentos = Documento::find()
                ->where(['ODO_ID' => $id])
                ->all();

        if($countDocumentos > 0 )
        {
            foreach($documentos as $documento ){
                echo "<option value='".$documento->DOC_CODIGO."'>".$documento->DOC_TITULO."</option>";
            }
        }
        else{
            echo "<option> - </option>";
        }

    }






}
