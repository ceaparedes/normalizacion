<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DerivacionReclamoSugerenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="derivacion-reclamo-sugerencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'DRS_ID') ?>

    <?= $form->field($model, 'EDR_ID') ?>

    <?= $form->field($model, 'USU_RUT') ?>

    <?= $form->field($model, 'SRS_ID') ?>

    <?= $form->field($model, 'DRS_CARGO') ?>

    <?php // echo $form->field($model, 'DRS_UNIDAD') ?>

    <?php // echo $form->field($model, 'DRS_FECHA_DERIVACION') ?>

    <?php // echo $form->field($model, 'DRS_FECHA_RESPUESTA') ?>

    <?php // echo $form->field($model, 'DRS_RESPUESTA') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
