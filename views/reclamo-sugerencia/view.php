<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;
use backend\models\Adjuntos;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = "Solicitud Nº: " . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if ($model->ERS_ID == 1){
        echo Html::a('Actualizar', ['update', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-primary']);

        echo Html::a('Evaluar', ['evaluate', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-success']);

        echo Html::a('Eliminar', ['delete', 'id' => $model->REC_NUMERO], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de eliminar esta Solicitud?',
                //'method' => 'post',
            ],
        ]);
      }else {
        echo Html::a('Volver', '?r=reclamo-sugerencia', ['class' => 'btn btn-default']);
      }
        ?>

    </p>

    <?php


            if(!$model->REC_VISTO_BUENO){
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
      if($adjunto && $model->ERS_ID !=5){
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
