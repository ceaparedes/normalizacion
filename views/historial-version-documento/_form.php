<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialVersionDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-version-documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'DOC_CODIGO')->textInput() ?>

    <?= $form->field($model, 'VER_ID')->textInput() ?>

    <?= $form->field($model, 'HVD_FECHA_HORA')->textInput() ?>

    <?= $form->field($model, 'HVD_COMENTARIO')->textInput() ?>

    <?= $form->field($model, 'HVD_VISTO_BUENO')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
