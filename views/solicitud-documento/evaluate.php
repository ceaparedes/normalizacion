<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


$this->title = 'Solicitud de Documentos Nº: ' . ' ' . $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SOL_ID, 'url' => ['view', 'id' => $model->SOL_ID]];
$this->params['breadcrumbs'][] = 'Evaluar';
?>


<div class="solicitud-documento-evaluate">
      <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

      <?php

          echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'SOL_ID',
              'eSO.ESO_ESTADO',
              'USU_RUT',
              'oDO.ODO_ORIGEN',
              'tAS.TAS_ACCION',
              'SOL_FECHA',
              'SOL_UNIDAD',
              'SOL_FUNDAMENTO',
          ],
      ]);

      echo DetailView::widget([
      'model' => $cambios,
      'attributes' => [
          'DCS_CAMBIOS'
      ],
  ]);

      echo DetailView::widget([
      'model' => $doc,
      'attributes' => [
          'DOC_CODIGO',
          'DOC_TITULO',
          'DOC_TIPO',
          'oDO.ODO_ORIGEN',
      ],
  ]);
   ?>

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'SOL_VISTO_BUENO')->radioList(array('Aprobado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>

      <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
          <span class="btn btn-xs btn-info no-radius" id="solicitud-documento-evaluate" onclick="submit">
            <i class="glyphicon glyphicon-pencil"></i>
          </span> Evaluar </label>',
         ['class' => 'btn btn-xs btn-white no-radius btn-info',
         'data' => [
             'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Evaluación?',
             'method' => 'post',
           ],]) ?>

        <?php $form = ActiveForm::end(); ?>

</div>
