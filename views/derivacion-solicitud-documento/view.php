<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\SolicitudDocumento;
use app\models\OrigenDocumento;
use app\models\TipoAccionSolicitud;

/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumento */

$this->title = 'Solicitud Derivada Nº: '$model->DSD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-solicitud-documento-view">

    <div class="page header"><h1><?= Html::encode($this->title) ?></h1></div>


  <?php
  echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </span> Volver </label>', '?r=solicitud-documento', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";?>

    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="derivacion-solicitud-documento-create" onclick="submit">
          <i class="glyphicon glyphicon-pencil"></i>
        </span> Crear Borrador </label>', 'create',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
       ]) ?>


        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'DSD_ID',
                //'SOL_ID',
                'USU_RUT',
                'DSD_CARGO',
                'DSD_UNIDAD',
                'DSD_FECHA_DERIVACION',
            ],
        ]) ?>

        <?= DetailView::widget([
            'model' => $solicitud,
            'attributes' => [
                'SOL_ID',
                'oDO.ODO_ORIGEN',
                'tAS.TAS_ACCION',
                'SOL_FUNDAMENTO',
            ],
        ]) ?>

</div>
