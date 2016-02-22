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
    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

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

    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
          <i class="glyphicon glyphicon-floppy-disk"></i>
        </span> Crear </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
       'data' => [
           'confirm' => 'Una vez escrito los resultados no se podrán efectuar cambios, ¿Está seguro de enviar los resultados?',
           'method' => 'post',
         ],]) ?>

    <?php $form = ActiveForm::end(); ?>

  </div>
