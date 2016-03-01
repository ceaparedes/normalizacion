<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Documento;
use app\models\SolicitudDocumento;
use app\models\VersionDocumento;
use app\models\DetalleCambiosSolicitud;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = "Solicitud " . $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-view">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?php
    if ($model->ESO_ID == 1 /*Guardado*/){

    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </span> Volver </label>', '?r=Solicitud-documento', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";
    //boton Actualizar
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon glyphicon-pencil"></i></span> Actualizar </label>', ['update', 'id' => $model->SOL_ID],
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


  }elseif ($model->ESO_ID == 2 /*enviado*/) {

      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon  glyphicon-pencil"></i></span>Evaluar</label>', ['evaluate', 'id' => $model->SOL_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo " ";
  }elseif($model->ESO_ID == 3 /*Aprobado por jefe directo*/ ) {
       Html::a('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius">
        <i class="ace-icon fa fa-expand"></i>
        </span> Evaluar</label>', ['nevaluate', 'id' => $model->SOL_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
        echo " "; //esto es lo que quiero eliminar con los roles ya implementados

  }elseif($model->ESO_ID == 5/*Aprobado por Normalizacion*/){

    Html::a('<label class="box-title pull-right margenbtnsuperior dark">
     <span class="btn btn-xs btn-info no-radius">
     <i class="ace-icon fa fa-send"></i>
     </span> Derivar</label>', ['derivate', 'id' => $model->SOL_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
     echo " ";

  }elseif ($model->ESO_ID == 6 /*Derivado a Normalizacion*/) {
    # code...
  }


    ?>

</p>
<div class="box-body table-responsive no-padding table-bordered siempre_responsivo">
<div class="bs-callout bs-callout-info">

    <?php

        echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOL_ID',
            'eSO.ESO_ESTADO',
            'USU_RUT',
            'tAS.TAS_ACCION',
            'SOL_FECHA',
            'SOL_UNIDAD',
            'SOL_FUNDAMENTO',

        ],
    ]);

        echo DetailView::widget([
        'model' => $cambios,
        'attributes' => [
            'DCS_CAMBIOS'
        ],
    ]);

        echo DetailView::widget([
        'model' => $doc,
        'attributes' => [
            'DOC_CODIGO',
            'DOC_TITULO',
            'DOC_TIPO',
            'oDO.ODO_ORIGEN',
        ],
    ]);



    if($adjunto ){
      //muestra el enlace al Archivo adjunto
      echo DetailView::widget([
      'model' => $adjunto,
      'attributes' => [

        [
          'attribute'=>'ADJ_URL',
          'format'=>'raw',
          'value'=>Html::a('Archivo Adjunto', $adjunto->ADJ_URL, ['target' => '_blank']),

        ],],
      ]); }

    ?>
</div>
