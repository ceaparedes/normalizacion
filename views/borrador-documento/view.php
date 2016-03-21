<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumento */

$this->title ='Borrador documento Solicitud '. $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Borrador Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrador-documento-view">

  

    <?php
    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </span> Volver </label>', '?r=solicitud-documento', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";

    echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
    <span class="btn btn-xs btn-info no-radius ">
    <i class="glyphicon  glyphicon-pencil"></i></span>Evaluar Borrador</label>', ['evaluate', 'id' => $model->BDO_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
    echo " ";


        echo DetailView::widget([
          'model' => $solicitud,
          'attributes' => [
              'SOL_ID',
              'oDO.ODO_ORIGEN',
              'tAS.TAS_ACCION',
              'SOL_FUNDAMENTO',
          ],
      ]);

      if($cambios){

        echo DetailView::widget([
          'model' => $cambios,
          'attributes' => [
              'DCS_CAMBIOS',
          ],
        ]);
      }

      echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'BDO_ID',
            'eBD.EBD_ESTADO',
            'BDO_FECHA_ENVIO',
        ],
      ]);

      if($adjunto){
      //muestra el enlace al Archivo adjunto
      echo DetailView::widget([
      'model' => $adjunto,
      'attributes' => [
        [
          'attribute'=>'ADJ_URL',
          'format'=>'raw',
          'value'=>Html::a('Borrador Documento', $adjunto->ADJ_URL, ['target' => '_blank']),

        ],],
      ]); }


    ?>

</div>
