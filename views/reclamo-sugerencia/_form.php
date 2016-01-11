<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reclamo-sugerencia-form">

    <?php $form = ActiveForm::begin(['options' =>
                              ['enctype' => 'multipart/form-data',
                              'enableAjaxValidation'=>true]]); ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'TSR_ID')->dropDownList(
        ArrayHelper::map(TIPOSOLICITANTERECLAMOSUGERENCIA::find()->all(),'TSR_ID','TSR_TIPO_SOLICITANTE'),
        ['prompt'=>'Seleccione un tipo']
    )  ?>

    <?= $form->field($model, 'TRS_ID')->dropDownList(
        ArrayHelper::map(TIPORECLAMOSUGERENCIA::find()->all(),'TRS_ID','TRS_TIPO'),
        ['prompt'=>'Seleccione el tipo de su Solicitud']
    )  ?>

    <?= $form->field($model, 'REC_NOMBRE_USUARIO')->textInput() ?>

    <?= $form->field($model, 'REC_EMAIL_USUARIO')->textInput() ?>

    <?= $form->field($model, 'REC_TELEFONO_USUARIO')->textInput() ?>

    <?= $form->field($model, 'REC_REPARTICION')->textInput() ?>

    <?= $form->field($model, 'REC_MOTIVO')->textArea(array('rows'=>6)) ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
