<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\controllers\ReclamoSugerenciaController;
use app\models\SolucionReclamoSugerencia;


?>
<div class="solucion-reclamo-sugerencia-form">

  <?php $form = ActiveForm::begin(['enableAjaxValidation'=>true]); ?>

  <?= $form->field($solucion, 'SRS_VISTO_BUENO')->radioList(array('Autorizado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>

  <?= $form->field($solucion, 'USU_RUT')->textInput() ?>

  <?= $form->field($solucion, 'SRS_COMENTARIO')->textArea(array('rows'=>4)) ?>



  <div class="form-group">
  <?= Html::submitInput('Evaluar', ['class' =>  'btn btn-success', 'data' => [
      'confirm' => 'Una vez enviada la respuesta no se podrán efectuar cambios, ¿Está seguro de enviar la Evaluación?',
      'method' => 'post',
    ],]) ?>
</div>


  <?php $form = ActiveForm::end(); ?>

</div>
