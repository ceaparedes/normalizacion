<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if ($model->ESO_ID == 1){
    //boton Actualizar
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon  glyphicon-pencil"></i></span> Actualizar </label>', ['update', 'id' => $model->SOL_ID],
    ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo ' ';

    //boton enviar
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
    <i class="glyphicon glyphicon-send"></i>
  </span>
  Enviar</label>', ['send', 'id' => $model->SOL_ID],

    ['class' => 'btn btn-xs btn-white no-radius btn-info',
    'data' => [
        'confirm' => 'Una vez enviada la Solicitud no se podrán efectuar cambios, ¿Está seguro de enviar la Solicitud?',
        'method' => 'post',
      ],
      ]);
      echo ' ';
      //boton eliminar
      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark"> <span class="btn btn-xs btn-info no-radius"><i class="glyphicon  glyphicon-trash"></i></span>  Eliminar </label>',['delete', 'id' => $model->SOL_ID],
          ['class' => 'btn btn-xs btn-white no-radius btn-info',
            'data' => [
            'confirm' => '¿Está seguro de eliminar esta Solicitud?',
            'method' => 'post',
            ],
      ]);


  }else {

    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon glyphicon-arrow-left"></i>
  </span> Volver </label>', '?r=reclamo-sugerencia', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
  echo " ";

    if( $model->ESO_ID == 2){
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon  glyphicon-pencil"></i></span>Evaluar</label>', ['evaluate', 'id' => $model->SOL_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";
  }else {
      /*echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius">
    <i class="ace-icon fa fa-expand"></i>
  </span> Ver Evaluacion</label>', ['solucion-reclamo-sugerencia/view', 'id' => $solucion->SRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo " ";*/

  }

  }
    ?>

</p>
<div class="box-body table-responsive no-padding table-bordered siempre_responsivo">
<div class="bs-callout bs-callout-info">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOL_ID',

            'eSO.ESO_ESTADO',
            'USU_RUT',
            'oDO.ODO_ORIGEN',
            'tAS.TAS_ACCION',
            'SOL_FECHA',
            'SOL_UNIDAD',
            'SOL_FUNDAMENTO',
        ],
    ]) ?>

</div>
