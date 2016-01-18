<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borrador-documento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'BDO_ID') ?>

    <?= $form->field($model, 'EBD_ID') ?>

    <?= $form->field($model, 'SOL_ID') ?>

    <?= $form->field($model, 'BDO_FECHA_ENVIO') ?>

    <?= $form->field($model, 'BDO_FECHA_RESPUESTA') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
