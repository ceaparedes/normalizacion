<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoSolucionReclamoSugerencia;
use frontend\models\DerivacionReclamoSugerencia;
use frontend\models\ReclamoSugerencia;
use frontend\models\SolucionReclamoSugerencia;


/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Respuesta a la Solicitud Derivada Nº: '. $model->DRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivaciones Realizadas a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Nº' .$model->SRS_ID, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Respuesta';
?>

<div class="Derivacion-reclamo-sugerencia-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sRS.rECNUMERO.REC_NUMERO',
            'sRS.rECNUMERO.tRS.TRS_TIPO',
            'sRS.rECNUMERO.REC_MOTIVO',
            'sRS.SRS_ANTECEDENTES',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>true]); ?>

    <?= $form->field($model, 'DRS_SERVICIO_NO_CONFORME')->radioList(array('Si'=>'Si','No'=>'No')); ?>

    <?= $form->field($model, 'DRS_RESPUESTA')->textArea(array('rows' =>3)) ?>

    <?= Html::submitInput('Responder', ['class' =>  'btn btn-primary']) ?>

    <?php $form = ActiveForm::end(); ?>

  </div>
