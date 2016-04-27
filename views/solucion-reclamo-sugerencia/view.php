<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\db\QueryTrait;
use app\models\Adjuntos;

/* @var $this yii\web\View */
/* @var $model frontend\models\SolucionReclamoSugerencia */

$this->title = "Solucion entregada a la solicitud Nº: " .$model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Soluciones a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solucion-reclamo-sugerencia-view">

  <div class="box-header margenb5 pull-right">
      <?php
      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
      </span> Volver </label>', '?r=reclamo-sugerencia', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo " ";

      if ($reclamo->ERS_ID == 3 ){

            echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
          <span class="btn btn-xs btn-info no-radius" id="agregaperiodo" onclick="envia()">
            <i class="glyphicon glyphicon-send"></i>
          </span>Derivar </label>', ['derivate', 'id' => $model->SRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info'
            ]);
            echo " ";

          }else {

            if($reclamo->ERS_ID == 6){
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
  </div>
<div class="page-header"><h1> <?= $this->title ?></h1></div>

<div class="bs-callout bs-callout-info">
  <div class="row" >
    <?php
          if($model->SRS_VISTO_BUENO== 'Autorizado'){
              echo DetailView::widget([
              'model' => $reclamo,
              'attributes' => [
                  'REC_NUMERO',
                  'tRS.TRS_TIPO',
                  'REC_NOMBRE_USUARIO',
                  'eRS.ERS_ESTADO',
                  'REC_MOTIVO',
                ],
                ]);
              echo DetailView::widget([
              'model' => $model,
              'attributes' => [

                  'SRS_NOMBRE',
                  'SRS_VISTO_BUENO',
                  'SRS_COMENTARIO',
                  //'SRS_FECHA_RESPUESTA',
                  'SRS_FECHA_ENVIO',
                ],
                ]);
            }else {
              echo DetailView::widget([
              'model' => $reclamo,
              'attributes' => [
                  'REC_NUMERO',
                  'tRS.TRS_TIPO',
                  'REC_NOMBRE_USUARIO',
                  'eRS.ERS_ESTADO',
                  'REC_MOTIVO',
                ],
                ]);
              echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'SRS_NOMBRE',
                  'SRS_VISTO_BUENO',
                  //'SRS_FECHA_RESPUESTA',
                  'SRS_FECHA_ENVIO',
                  'SRS_COMENTARIO',
                ],
                ]);

            }

          if($contador >0){
            //muestra el enlace al Archivo adjunto
            $query = new Query;
            $query->select ('ADJ_ID')
                ->from('ADJUNTOS')
                ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
            $query = $query->All();

            for ($i=0; $i <$contador ; $i++) {
              $adj = new Adjuntos();
              $adj = $adj->findOne($query[$i]);
              echo DetailView::widget([
              'model' => $adj,
              'attributes' => [
                    [
                      'attribute'=>'ADJ_URL',
                      'format'=>'raw',
                      'value'=>Html::a('Vea aquí el Archivo Adjunto', $adj->ADJ_URL, ['target' => '_blank']),
                    ],
              ],
            ]);
          }
        }

    ?>
  </div>
</div>
</div>
