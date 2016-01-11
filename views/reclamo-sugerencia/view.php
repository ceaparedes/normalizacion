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
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if ($model->ERS_ID == 1){

        echo Html::a('Actualizar', ['update', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-primary']);
        echo ' ';

        echo Html::a('Enviar', ['send', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-success',
        'data' => [
            'confirm' => 'Una vez enviada la Solicitud no se podrán efectuar cambios, ¿Está seguro de enviar la Solicitud?',
            'method' => 'post',
          ],
          ]);
          echo ' ';

        echo Html::a('Eliminar', ['delete', 'id' => $model->REC_NUMERO], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta Solicitud?',
                'method' => 'post',
            ],
        ]);
      }else {

        if( $model->ERS_ID == 2){
        echo Html::a('Evaluar', ['evaluate', 'id' => $model->REC_NUMERO], ['class' => 'btn btn-success']);
        echo " ";
      }else {
          echo Html::a('Ver Evaluacion', ['solucion-reclamo-sugerencia/view', 'id' => $solucion->SRS_ID], ['class' => 'btn btn-default']);
          echo " ";

      }
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
