<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialSolicitud */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-solicitud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ESO_ID')->textInput() ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'SOL_ID')->textInput() ?>

    <?= $form->field($model, 'HSO_FECHA')->textInput() ?>

    <?= $form->field($model, 'HSO_COMENTARIO')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
