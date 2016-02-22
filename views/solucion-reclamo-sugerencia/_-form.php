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





       <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
           <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
             <i class="glyphicon glyphicon-pencil"></i>
           </span> Evaluar </label>',
          ['class' => 'btn btn-xs btn-white no-radius btn-info',
            ]) ?>




  <?php $form = ActiveForm::end(); ?>

</div>
