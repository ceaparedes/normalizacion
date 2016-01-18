<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="derivacion-solicitud-documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'EDS_ID')->textInput() ?>

    <?= $form->field($model, 'SOL_ID')->textInput() ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'DSD_CARGO')->textInput() ?>

    <?= $form->field($model, 'DSD_UNIDAD')->textInput() ?>

    <?= $form->field($model, 'DSD_FECHA_DERIVACION')->textInput() ?>

    <?= $form->field($model, 'DSD_FECHA_RESPUESTA')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
