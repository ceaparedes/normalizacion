<?php

//use yii tools
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\db\QueryTrait;

//use app models
use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\Adjuntos;


/* @var $this yii\web\View */
/* @var $model frontend\models\DerivacionReclamoSugerencia */

$this->title ="Derivacion de Solicitud Nº". $model->DRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivaciones Realizadas a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-reclamo-sugerencia-view">


      <div class="box-header margenb5 pull-right">
      <?php
      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon glyphicon-arrow-left"></i>
      </span> Volver </label>', '?r=reclamo-sugerencia', ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo " ";


      if($model->EDR_ID == 1 && Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO' && $reclamo->TRS_ID != 3 /*&& Yii::$app->user->identity->rut == $model->USU_RUT*/){
      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
    <span class="btn btn-xs btn-info no-radius ">
      <i class="glyphicon  glyphicon-pencil"></i></span> Rsponder </label>', ['answer', 'id' => $model->DRS_ID], ['class' => 'btn btn-xs btn-white no-radius btn-info']);
      echo " ";
    }?>

  </div>

    <div class="page-header"><h1> <?= $this->title ?></h1></div>

<div class="bs-callout bs-callout-info">
<div class="row" >
    <?php


      echo DetailView::widget([
         'model' => $reclamo,
         'attributes' => [
             'REC_NUMERO',
             'tRS.TRS_TIPO',
             'REC_MOTIVO',
             ],
     ]);
     echo DetailView::widget([
        'model' => $solucion,
        'attributes' => [
            'SRS_NOMBRE',
            'SRS_SERVICIO_NO_CONFORME',
            'SRS_COMENTARIO',
            'SRS_ANTECEDENTES',

            ],
    ]);
    if(!$model->DRS_RESPUESTA){
    echo DetailView::widget([
       'model' => $model,
       'attributes' => [
           'DRS_FECHA_DERIVACION',
           'DRS_NOMBRE',
           'DRS_CARGO',
           'DRS_UNIDAD'
           ],
   ]);
   }else{
        echo DetailView::widget([
      'model' => $model,
      'attributes' => [
          'DRS_FECHA_DERIVACION',
          'DRS_NOMBRE',
          'DRS_CARGO',
          'DRS_UNIDAD',
          'DRS_RESPUESTA',
          'DRS_FECHA_RESPUESTA'
          ],
  ]);
  }

  if($contador_adj_usuarios >0){
    echo '<h3 id="badges" class="header smaller lighter blue">Archivos Presentados por el Usuario</h3>';
    //muestra el enlace al Archivo adjunto
    $query = new Query;
    $query->select ('ADJ_ID')
        ->from('ADJUNTOS')
        ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Reclamo-Sugerencia'", [':reclamo' => $reclamo->REC_NUMERO]);
    $query = $query->All();

    for ($i=0; $i <$contador_adj_usuarios ; $i++) {
      $adj = new Adjuntos();
      $adj = $adj->findOne($query[$i]);
      echo DetailView::widget([
      'model' => $adj,
      'attributes' => [

        [
          'attribute'=>'ADJ_URL',
          'format'=>'raw',
          'label' => 'Adjuntos Presentados por el Usuario',
          'value'=>Html::a('Vea aquí el Archivo Adjunto', $adj->ADJ_URL, ['target' => '_blank']),

        ],

      ],
    ]);


    }


  }


   //si existe el adjunto
   if($contador_sac_sap >0 && $model->DRS_RESPUESTA == NULL){
     echo '<h3 id="badges" class="header smaller lighter blue">SAC-SAP a Completar</h3>';
     //muestra el enlace al Archivo adjunto
     $query = new Query;
     $query->select ('ADJ_ID')
         ->from('ADJUNTOS')
           ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Derivacion-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
     $query = $query->All();

     for ($i=0; $i <$contador_sac_sap ; $i++) {
       $adj = new Adjuntos();
       $adj = $adj->findOne($query[$i]);
       echo DetailView::widget([
       'model' => $adj,
       'attributes' => [

         [
           'attribute'=>'ADJ_URL',
           'format'=>'raw',
           'label'=>'SAC-SAP Adjunto',
           'value'=>Html::a('Vea aquí el Archivo Adjunto', $adj->ADJ_URL, ['target' => '_blank']),

         ],

       ],
     ]);


     }


   }
   //si existe el adjunto
   if($contador_respuestas >0 && $model->DRS_RESPUESTA != NULL){
     echo '<h3 id="badges" class="header smaller lighter blue">SAC-SAP a Completar</h3>';
     //muestra el enlace al Archivo adjunto

     $query = new Query;
     $query->select ('ADJ_ID')
         ->from('ADJUNTOS')
         ->where("REC_NUMERO=:reclamo AND DRS_ID=:derivacion AND ADJ_TIPO = 'respuesta-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO, 'derivacion' => $model->DRS_ID]);
     $query = $query->All();

     for ($i=0; $i <$contador_respuestas ; $i++) {
       $adj = new Adjuntos();
       $adj = $adj->findOne($query[$i]);
       echo DetailView::widget([
       'model' => $adj,
       'attributes' => [

         [
           'attribute'=>'ADJ_URL',
           'format'=>'raw',
           'label'=>'SAC-SAP Adjunto',
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
