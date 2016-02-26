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
              'SOL_VISTO_BUENO',
          ],
      ]);

        echo DetailView::widget([
          'model' => $docs,
          'attributes' => [
              'titulo',
          ],
      ]); ?>

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'SOL_VISTO_BUENO')->radioList(array('Aprobado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>

      <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
          <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
            <i class="glyphicon glyphicon-pencil"></i>
          </span> Evaluar </label>',
         ['class' => 'btn btn-xs btn-white no-radius btn-info',
         'data' => [
             'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Derivación?',
             'method' => 'post',
           ],]) ?>

        <?php $form = ActiveForm::end(); ?>

</div>
