<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;
use backend\models\EstadoSolucionReclamoSugerencia;
use frontend\models\DerivacionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Reclamo Sugerencia: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Derivar';
?>

<div class="solucion-reclamo-sugerencia-derivate">
    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>
    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'REC_NUMERO',
            'rECNUMERO.tRS.TRS_TIPO',
            'rECNUMERO.REC_MOTIVO',
            'rECNUMERO.REC_VISTO_BUENO',
            'rECNUMERO.eRS.ERS_ESTADO',
            'SRS_COMENTARIO',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SRS_ANTECEDENTES')->textArea(array('rows'=>4)) ?>
    <?= $form->field($derivacion, 'USU_RUT')->textInput() ?>
    <?= $form->field($derivacion, 'DRS_CARGO')->textInput() ?>
    <?= $form->field($derivacion, 'DRS_UNIDAD')->textInput() ?>

    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
          <i class="glyphicon glyphicon-send"></i>
        </span> Derivar </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
       'data' => [
           'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Derivación?',
           'method' => 'post',
         ],]) ?>



    <?php $form = ActiveForm::end(); ?>

  </div>
