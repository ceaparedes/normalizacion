<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SOL_ID')->textInput() ?>

    <?= $form->field($model, 'DOC_CODIGO')->textInput() ?>

    <?= $form->field($model, 'VER_ID')->textInput() ?>

    <?= $form->field($model, 'PDA_ID')->textInput() ?>

    <?= $form->field($model, 'ESO_ID')->textInput() ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'ODO_ID')->textInput() ?>

    <?= $form->field($model, 'TAS_ID')->textInput() ?>

    <?= $form->field($model, 'SIS_ID')->textInput() ?>

    <?= $form->field($model, 'SRS_ID')->textInput() ?>

    <?= $form->field($model, 'SOL_FECHA')->textInput() ?>

    <?= $form->field($model, 'SOL_UNIDAD')->textInput() ?>

    <?= $form->field($model, 'SOL_FUNDAMENTO')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
