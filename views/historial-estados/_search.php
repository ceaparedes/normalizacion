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

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'REC_NUMERO') ?>


    <?= $form->field($model, 'ERS_ID')->dropDownList(
        ArrayHelper::map(ESTADORECLAMOSUGERENCIA::find()->Where(['ERS_ID'=>[2,3,4,5,6,7],])->all(),'ERS_ID','ERS_ESTADO'),
        ['prompt'=>' ']
    )  ?>

    <?= $form->field($model, 'USU_RUT') ?>




    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
