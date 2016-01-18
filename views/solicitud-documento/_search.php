<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-documento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SOL_ID') ?>

    <?= $form->field($model, 'DOC_CODIGO') ?>

    <?= $form->field($model, 'VER_ID') ?>

    <?= $form->field($model, 'PDA_ID') ?>

    <?= $form->field($model, 'ESO_ID') ?>

    <?php // echo $form->field($model, 'USU_RUT') ?>

    <?php // echo $form->field($model, 'ODO_ID') ?>

    <?php // echo $form->field($model, 'TAS_ID') ?>

    <?php // echo $form->field($model, 'SIS_ID') ?>

    <?php // echo $form->field($model, 'SRS_ID') ?>

    <?php // echo $form->field($model, 'SOL_FECHA') ?>

    <?php // echo $form->field($model, 'SOL_UNIDAD') ?>

    <?php // echo $form->field($model, 'SOL_FUNDAMENTO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
