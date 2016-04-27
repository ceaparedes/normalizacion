<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\EstadoReclamoSugerencia;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model app\models\ReclamoSugerenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reclamo-sugerencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="bs-callout bs-callout-info no-bottom">

    <div class="form-group align-center">
      <?= $form->field($model, 'REC_NUMERO')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'REC_NOMBRE_USUARIO')->textInput(['class'=>'form-horizontal']) ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'ERS_ID')->dropDownList(
          ArrayHelper::map(ESTADORECLAMOSUGERENCIA::find()->Where(['ERS_ID'=>[2,3,4,5,6,7,8,9,10,11],])->all(),'ERS_ID','ERS_ESTADO'),
          ['prompt'=>' ',
          'class'=>'form-horizontal']
      )  ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'TSR_ID')->dropDownList(
          ArrayHelper::map(TipoSolicitanteReclamoSugerencia::find()->all(),'TSR_ID','TSR_TIPO_SOLICITANTE'),
          ['prompt'=>' ',
          'class'=>'form-horizontal']
      )  ?>
    </div>

    <div class="form-group align-center">
      <?= $form->field($model, 'TRS_ID')->dropDownList(
          ArrayHelper::map(TipoReclamoSugerencia::find()->all(),'TRS_ID','TRS_TIPO'),
          ['prompt'=>' ',
          'class'=>'form-horizontal']
      )  ?>
    </div>

    <?php // echo $form->field($model, 'REC_HORA') ?>

    <?php // echo $form->field($model, 'USU_RUT') ?>

    <?php // echo $form->field($model, 'REC_NOMBRE_USUARIO') ?>

    <?php // echo $form->field($model, 'REC_EMAIL_USUARIO') ?>

    <?php // echo $form->field($model, 'REC_TELEFONO_USUARIO') ?>

    <?php // echo $form->field($model, 'REC_MOTIVO') ?>

    <?php // echo $form->field($model, 'REC_VISTO_BUENO') ?>
    </div>

    <div class="panel-footer">
      <center>
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info']) ?>
      </center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
