<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\EstadoSolicitud

/* @var $this yii\web\View */
/* @var $model app\models\HistorialSolicitudSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-solicitud-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SOL_ID') ?>

    <?= $form->field($model, 'ESO_ID')->dropDownList(
        ArrayHelper::map(ESTADOSOLICITUD::find()->Where(['ESO_ID'=>[2,3,4,5],])->all(),'ESO_ID','ESO_ESTADO'),
        ['prompt'=>' ']
    )  ?>

    <?= $form->field($model, 'HSO_FECHA') ?>

    

    <div class="form-group">
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
