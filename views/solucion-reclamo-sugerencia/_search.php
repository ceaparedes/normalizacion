<?php
//use Yii Tools
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SolucionReclamoSugerenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solucion-reclamo-sugerencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<div class="bs-callout bs-callout-info no-bottom">
    <div class="form-group align-center">
      <?= $form->field($model, 'REC_NUMERO')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'USU_RUT')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'ESR_ID')->textInput(['class'=>'form-horizontal']) ?>
    </div>


    <?php // echo $form->field($model, 'SRS_COMENTARIO') ?>

    <?php // echo $form->field($model, 'SRS_ANTECEDENTES') ?>

    <?php // echo $form->field($model, 'SRS_FECHA_RESPUESTA') ?>

    <?php // echo $form->field($model, 'SRS_FECHA_ENVIO') ?>


    <div class="panel-footer">
      <center>
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info']) ?>
      </center>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
