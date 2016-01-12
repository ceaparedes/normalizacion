<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;
use backend\models\EstadoSolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Reclamo Sugerencia: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Resultados';
?>

<div class="solucion-reclamo-sugerencia-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'REC_NUMERO',
            'rECNUMERO.tRS.TRS_TIPO',
            'rECNUMERO.REC_MOTIVO',
            'rECNUMERO.REC_VISTO_BUENO',
            'rECNUMERO.eRS.ERS_ESTADO',
            'SRS_VISTO_BUENO',
            'eSR.ESR_ESTADO',
            'SRS_COMENTARIO',
            'SRS_ANTECEDENTES',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SRS_RESULTADOS')->textArea(array('rows' =>3)) ?>

    <?= Html::submitInput('Crear', ['class' =>  'btn btn-primary']) ?>

    <?php $form = ActiveForm::end(); ?>

  </div>
