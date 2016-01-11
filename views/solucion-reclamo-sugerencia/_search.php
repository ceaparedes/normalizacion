<?php

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

    <?= $form->field($model, 'SRS_ID') ?>

    <?= $form->field($model, 'USU_RUT') ?>

    <?= $form->field($model, 'REC_NUMERO') ?>

    <?= $form->field($model, 'ESR_ID') ?>

    <?= $form->field($model, 'SRS_VISTO_BUENO') ?>

    <?php // echo $form->field($model, 'SRS_COMENTARIO') ?>

    <?php // echo $form->field($model, 'SRS_ANTECEDENTES') ?>

    <?php // echo $form->field($model, 'SRS_FECHA_RESPUESTA') ?>

    <?php // echo $form->field($model, 'SRS_FECHA_ENVIO') ?>

    <?php // echo $form->field($model, 'SRS_RESULTADOS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
