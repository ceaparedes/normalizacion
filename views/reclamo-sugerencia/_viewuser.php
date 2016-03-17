<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\Adjuntos;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

?>


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
      if($adjunto){
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
