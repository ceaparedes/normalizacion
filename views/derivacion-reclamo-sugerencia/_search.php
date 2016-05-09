<?php

//use Yii Tools
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//use app models
use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\ReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\DerivacionReclamoSugerenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="derivacion-reclamo-sugerencia-search">

  <div class="bs-callout bs-callout-info no-bottom">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group align-center">
      <?= $form->field($model, 'SRS_ID')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'EDR_ID')->dropDownList(
          ArrayHelper::map(EstadoDerivacionReclamoSugerencia::find()->all(),'EDR_ID','EDR_ESTADO'),
          ['prompt'=>' ',
          'class'=>'form-horizontal']
      )  ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'DRS_CARGO')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'DRS_UNIDAD')->textInput(['class'=>'form-horizontal']) ?>
    </div>
    
    <?php // echo $form->field($model, 'DRS_FECHA_DERIVACION') ?>

    <?php // echo $form->field($model, 'DRS_FECHA_RESPUESTA') ?>

    <?php // echo $form->field($model, 'DRS_RESPUESTA') ?>

    <div class="panel-footer">
      <center>
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info']) ?>
      </center>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
