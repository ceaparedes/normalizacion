<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SolucionReclamoSugerencia;
use app\controllers\ReclamoSugerenciaController;


?>
<div class="reclamo-sugerencia-form">

  <?php $form = ActiveForm::begin(); ?>


  <?= $form->field($reclamo, 'REC_VISTO_BUENO')->radioList(array('Aprobado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>







  <?php $form = ActiveForm::end(); ?>

</div>
