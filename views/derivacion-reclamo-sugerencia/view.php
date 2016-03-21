<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\EstadoDerivacionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\DerivacionReclamoSugerencia */

$this->title ="Derivacion de Solicitud Nº". $model->DRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivaciones Realizadas a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-reclamo-sugerencia-view">

  
    <p>
      <?= Html::a('Inicio', ['/site/index'], ['class' => 'btn btn-default']) ?>
      <?php
      if($model->EDR_ID == 1 ){
      echo Html::a('Responder ', ['answer', 'id' => $model->DRS_ID], ['class' => 'btn btn-success']);
      echo " ";
    }?>

    <?= Html::a('Ver Soluciones', ['solucion-reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Ver Solicitudes Derivadas', ['index'], ['class' => 'btn btn-primary']) ?>


      <!--
         Html::a('Eliminar', ['delete', 'id' => $model->DRS_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que quiere eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?php
    if(!$model->DRS_RESPUESTA){
      echo DetailView::widget([
         'model' => $model,
         'attributes' => [
             'DRS_ID',
             'eDR.EDR_ESTADO',
             'USU_RUT',
             'SRS_ID',
             'DRS_CARGO',
             'DRS_UNIDAD',
             'DRS_FECHA_DERIVACION',
             //'DRS_FECHA_RESPUESTA',
             //'DRS_RESPUESTA',
         ],
     ]);
   }else{
     echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'DRS_ID',
            'eDR.EDR_ESTADO',
            'USU_RUT',
            'SRS_ID',
            'DRS_CARGO',
            'DRS_UNIDAD',
            'DRS_FECHA_DERIVACION',
            'DRS_FECHA_RESPUESTA',
            'DRS_RESPUESTA',
        ],
    ]);

   }


     ?>

</div>
