<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\SolicitudDocumento;
use app\models\OrigenDocumento;
use app\models\TipoAccionSolicitud;

/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumento */

$this->title = 'Solicitud Derivada Nº: ' . $model->DSD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-solicitud-documento-view">

    

  <?php
  echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </span> Volver </label>', '?r=solicitud-documento', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";

    if($solicitud->ESO_ID == 7){

      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
    <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon  glyphicon-pencil"></i></span> Subir Borrador Documento </label>', ['borrador', 'id'=>$model->DSD_ID],
      ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo ' ';
    }


          echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                  //'DSD_ID',
                  'USU_RUT',
                  'DSD_CARGO',
                  'DSD_UNIDAD',
                  'DSD_FECHA_DERIVACION',
              ],
          ]);

          echo DetailView::widget([
            'model' => $solicitud,
            'attributes' => [
                'SOL_ID',
                'oDO.ODO_ORIGEN',
                'tAS.TAS_ACCION',
                'SOL_FUNDAMENTO',
            ],
        ]);

        if($cambios){

          echo DetailView::widget([
            'model' => $cambios,
            'attributes' => [
                'DCS_CAMBIOS',
            ],
        ]);

        }

      ?>

</div>
