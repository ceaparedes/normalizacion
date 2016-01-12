<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SolucionReclamoSugerencia */

$this->title = "Solucion entregada a la solicitud Nº: " .$model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Soluciones a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solucion-reclamo-sugerencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?php

      echo Html::a('Inicio', ['/site/index'], ['class' => 'btn btn-default']);
      echo ' ';

      if ($model->ESR_ID == 1 && $model->SRS_VISTO_BUENO == 'Autorizado'){


            echo Html::a('Derivar', ['derivate', 'id' => $model->SRS_ID], ['class' => 'btn btn-success'
            ]);
            echo " ";

          }else {
            if($model->ESR_ID == 2){
            echo Html::a('Ver Solicitudes Derivadas', ['/derivacion-reclamo-sugerencia/index'], ['class' => 'btn btn-success'
            ]);
            echo " ";
          }

          }







      echo Html::a('Ver Reclamos y Sugerencias', ['/reclamo-sugerencia/index'], ['class' => 'btn btn-primary']);


      ?>

        <!--
        <?= Html::a('Eliminar', ['delete', 'id' => $model->SRS_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta Seguro de eliminar la solicitud?',
                'method' => 'post',
            ],
        ]) ?>
        -->
    </p>

    <?php
        if(!$model->SRS_RESULTADOS){
          if($model->SRS_VISTO_BUENO== 'Autorizado'){
              echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'SRS_ID',
                  'USU_RUT',
                  'REC_NUMERO',
                  'eSR.ESR_ESTADO',
                  'SRS_VISTO_BUENO',
                  'SRS_COMENTARIO',
                  'SRS_ANTECEDENTES',
                  //'SRS_FECHA_RESPUESTA',
                  'SRS_FECHA_ENVIO',
                  //'SRS_RESULTADOS',
                ],
                ]);
            }else {
              echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'SRS_ID',
                  'USU_RUT',
                  'REC_NUMERO',
                  'eSR.ESR_ESTADO',
                  'SRS_VISTO_BUENO',
                  'SRS_COMENTARIO',
                  //'SRS_ANTECEDENTES',
                  //'SRS_FECHA_RESPUESTA',
                  'SRS_FECHA_ENVIO',
                  //'SRS_RESULTADOS',
                ],
                ]);

            }
        }else{
          echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'SRS_ID',
              'USU_RUT',
              'REC_NUMERO',
              'ESR_ID',
              'SRS_VISTO_BUENO',
              'SRS_COMENTARIO',
              'SRS_ANTECEDENTES',
              'SRS_FECHA_RESPUESTA',
              'SRS_FECHA_ENVIO',
              'SRS_RESULTADOS',


        ],
      ]);
    }
    if($adjunto ){
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
