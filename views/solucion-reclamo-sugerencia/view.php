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

    <p>
      <?php

      if ($reclamo->ERS_ID == 3){

            echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
          <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
            <i class="glyphicon glyphicon-send"></i>
          </span>Derivar </label>', ['derivate', 'id' => $model->SRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info'
            ]);
            echo " ";

          }else {

            if($reclamo->ERS_ID == 4 || $reclamo->ERS_ID == 6){
              echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
            <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
              <i class="glyphicon glyphicon-pencil"></i>
            </span>Evaluar Respuesta</label>', ['evaluate' , 'id' => $model->SRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info'
              ]);
              echo " ";
            }
            if($reclamo->ERS_ID == 5){
              if($reclamo->ERS_ID == 4 || $reclamo->ERS_ID == 6){
                echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
              <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
                <i class="glyphicon glyphicon-send"></i>
              </span>Ver Derivaciones Realizadas</label>', ['derivacion-reclamo-sugerencia/index'], ['class' => 'btn btn-xs btn-white no-radius btn-info'
                ]);
                echo " ";

            }
          }
        }




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
<div class="col-xs-8" >
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
</div>
