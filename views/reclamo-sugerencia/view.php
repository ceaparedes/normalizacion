<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\Adjuntos;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = "Solicitud Nº: " . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-view">

    <p>
        <?php
        if ($model->ERS_ID == 1){
        //boton Actualizar
        echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
        <i class="glyphicon  glyphicon-pencil"></i></span> Actualizar </label>', ['update', 'id' => $model->REC_NUMERO],
        ['class' => 'btn btn-xs btn-white no-radius btn-info']);
        echo ' ';
        //boton enviar
        echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
        <i class="glyphicon glyphicon-send"></i>
      </span>
      Enviar</label>', ['send', 'id' => $model->REC_NUMERO],

        ['class' => 'btn btn-xs btn-white no-radius btn-info',
        'data' => [
            'confirm' => 'Una vez enviada la Solicitud no se podrán efectuar cambios, ¿Está seguro de enviar la Solicitud?',
            'method' => 'post',
          ],
          ]);
          echo ' ';
          //boton eliminar
          echo Html::a('<label class="box-title pull-right margenbtnsuperior dark"> <span class="btn btn-xs btn-info no-radius"><i class="glyphicon  glyphicon-trash"></i></span>  Eliminar </label>',['delete', 'id' => $model->REC_NUMERO],
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

        if( $model->ERS_ID == 2){
        echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
        <i class="glyphicon  glyphicon-pencil"></i></span>Evaluar</label>', ['evaluate', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
        echo " ";
      }else {
          echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius">
        <i class="ace-icon fa fa-expand"></i>
      </span> Ver Evaluacion</label>', ['solucion-reclamo-sugerencia/view', 'id' => $solucion->SRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
          echo " ";

      }

      }
        ?>

    </p>
<div class="box-body table-responsive no-padding table-bordered siempre_responsivo">
  <div class="bs-callout bs-callout-info">
    <?php


            if(!$model->REC_VISTO_BUENO){
            echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'REC_NUMERO',
                //'USU_RUT',
                'REC_NOMBRE_USUARIO',
                'REC_EMAIL_USUARIO',
                'REC_TELEFONO_USUARIO',
                'tSR.TSR_TIPO_SOLICITANTE',
                'tRS.TRS_TIPO',
                'REC_FECHA',
                'REC_REPARTICION',
                'REC_HORA',
                'REC_MOTIVO',
                'eRS.ERS_ESTADO',
                //'REC_VISTO_BUENO',
            ],
        ]);
      }else {
        echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'REC_NUMERO',
            'USU_RUT',
            'REC_NOMBRE_USUARIO',
            'REC_EMAIL_USUARIO',
            'REC_TELEFONO_USUARIO',
            'tSR.TSR_TIPO_SOLICITANTE',
            'tRS.TRS_TIPO',
            'REC_FECHA',
            'REC_REPARTICION',
            'REC_HORA',
            'REC_MOTIVO',
            'eRS.ERS_ESTADO',
            'REC_VISTO_BUENO',
              ],
            ]);

      }
      //si existe el adjunto y el reclamo no esta eliminado
      if($adjunto && $model->ERS_ID !=8){
        //muestra el enlace al Archivo adjunto
        echo DetailView::widget([
        'model' => $adjunto,
        'attributes' => [

          [
            'attribute'=>'ADJ_URL',
            'format'=>'raw',
            'value'=>Html::a('Archivo Adjunto', $adjunto->ADJ_URL, ['target' => '_blank']),

          ],

        ],
      ]);

      }


     ?>
</div>
</div>
</div>
