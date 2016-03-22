<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Documento;
use app\models\SolicitudDocumento;
use app\models\VersionDocumento;
use app\models\DetalleCambiosSolicitud;
use app\models\BorradorDocumento;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = "Solicitud " . $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-view">



    <?php
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </span> Volver </label>', '?r=solicitud-documento', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";
    if ($model->ESO_ID == 1 /*Guardado*/){

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

    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon glyphicon-send"></i></span> Derivar </label>', ['derivate', 'id' => $model->SOL_ID],
    ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo ' ';



  }elseif ($model->ESO_ID == 7 /*Derivado a Normalizacion*/) {
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="ace-icon fa fa-expand"></i></span> Ver Derivacion </label>', ['derivacion-solicitud-documento/view', 'id' => $derivacion->DSD_ID],
    ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo ' ';

  }elseif($model->ESO_ID == 8 && $borrador !=NULL){


    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
  <span class="btn btn-xs btn-info no-radius ">
    <i class="ace-icon fa fa-expand"></i></span> Ver Borrador Documento </label>', ['borrador-documento/view', 'id' => $borrador->BDO_ID],
    ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo ' ';

  }elseif ($model->ESO_ID == 9) {
    # code...
  }


    ?>

</p>

<div class="bs-callout bs-callout-info">
<div class="col-xs-6" >
    <?php

        echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOL_ID',
            'USU_RUT',
            'tAS.TAS_ACCION',
            'SOL_FECHA',
            'SOL_UNIDAD',
            'eSO.ESO_ESTADO',
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
</div>
