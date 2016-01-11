<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SolucionReclamoSugerencia;
use app\controllers\ReclamoSugerenciaController;


?>
<div class="reclamo-sugerencia-form">

  <?php $form = ActiveForm::begin(); ?>


  <?= $form->field($reclamo, 'REC_VISTO_BUENO')->radioList(array('Autorizado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>


  <?= Html::submitInput('Envaluar', ['class' =>  'btn btn-primary']) ?>



  <?php $form = ActiveForm::end(); ?>

</div>
