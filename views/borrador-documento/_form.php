<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borrador-documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'EBD_ID')->textInput() ?>

    <?= $form->field($model, 'SOL_ID')->textInput() ?>

    <?= $form->field($model, 'BDO_FECHA_ENVIO')->textInput() ?>

    <?= $form->field($model, 'BDO_FECHA_RESPUESTA')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
