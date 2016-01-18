<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="derivacion-solicitud-documento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'DSD_ID') ?>

    <?= $form->field($model, 'EDS_ID') ?>

    <?= $form->field($model, 'SOL_ID') ?>

    <?= $form->field($model, 'USU_RUT') ?>

    <?= $form->field($model, 'DSD_CARGO') ?>

    <?php // echo $form->field($model, 'DSD_UNIDAD') ?>

    <?php // echo $form->field($model, 'DSD_FECHA_DERIVACION') ?>

    <?php // echo $form->field($model, 'DSD_FECHA_RESPUESTA') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
