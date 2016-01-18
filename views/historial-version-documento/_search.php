<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialVersionDocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-version-documento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'HVD_ID') ?>

    <?= $form->field($model, 'USU_RUT') ?>

    <?= $form->field($model, 'DOC_CODIGO') ?>

    <?= $form->field($model, 'VER_ID') ?>

    <?= $form->field($model, 'HVD_FECHA_HORA') ?>

    <?php // echo $form->field($model, 'HVD_COMENTARIO') ?>

    <?php // echo $form->field($model, 'HVD_VISTO_BUENO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
