<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reclamo-sugerencia-form">

    <?php $form = ActiveForm::begin(['options' =>
                              ['enctype' => 'multipart/form-data',
                              'enableAjaxValidation'=>true]]); ?>


    <?= $form->field($model, 'TRS_ID')->dropDownList(
        ArrayHelper::map(TIPORECLAMOSUGERENCIA::find()->all(),'TRS_ID','TRS_TIPO'),
        ['prompt'=>'Seleccione el tipo de su Solicitud']
    )  ?>


    <?= $form->field($model, 'REC_MOTIVO')->textArea(array('rows'=>6)) ?>

    <?= $form->field($model, 'file')->fileInput() ?>



      <div class="form-group">


           <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
               <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
               </span> Guardar </label>',
              ['class' => 'btn btn-xs btn-white no-radius btn-info',
           ]) ?>

   </div>

  <?php ActiveForm::end(); ?>

</div>
