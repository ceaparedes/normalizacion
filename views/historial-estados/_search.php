<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\EstadoReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistorialEstadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historial-estados-search">

    <div class="bs-callout bs-callout-info no-bottom">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'REC_NUMERO') ?>


    <?= $form->field($model, 'ERS_ID')->dropDownList(
        ArrayHelper::map(ESTADORECLAMOSUGERENCIA::find()->Where(['ERS_ID'=>[2,3,4,5,6,7,8,9,10,11],])->all(),'ERS_ID','ERS_ESTADO'),
        ['prompt'=>' ']
    )  ?>

    <?= $form->field($model, 'USU_RUT') ?>




    <div class="form-group">
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
