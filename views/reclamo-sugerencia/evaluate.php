<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\SolucionReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;

$this->title = 'Reclamo Sugerencia: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->REC_NUMERO]];
$this->params['breadcrumbs'][] = 'Evaluar';
?>

<div class="reclamo-sugerencia-evaluate">


  <?=DetailView::widget([
      'model' => $model,
      'attributes' => [
          'REC_NUMERO',
          'USU_RUT',
          'REC_NOMBRE_USUARIO',
          'tRS.TRS_TIPO',
          'REC_FECHA',
          'REC_REPARTICION',
          'REC_MOTIVO',
          'eRS.ERS_ESTADO',
      ],
  ]) ?>
<div class="col-xs-6" >
  <?=   $this->render('_-form', [
        'model' => $model,
        'solucion'=>$solucion,
    ])?>
</div>

</div>
