<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialSolicitudSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-solicitud-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'HSO_ID') ?>

    <?= $form->field($model, 'ESO_ID') ?>

    <?= $form->field($model, 'USU_RUT') ?>

    <?= $form->field($model, 'SOL_ID') ?>

    <?= $form->field($model, 'HSO_FECHA') ?>

    <?php // echo $form->field($model, 'HSO_COMENTARIO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
