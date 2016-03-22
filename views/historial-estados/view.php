<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistorialEstados */

$this->title = 'Historial de la Solicitud Nº: ' . $model->REC_NUMERO;

$this->params['breadcrumbs'][] = ['label' => 'Evolutivo de Reclamos y Suregencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualización Nº'.$this->title;
?>
<div class="historial-estados-view">



    <p>
        <?= Html::a('Volver a menú Anterior', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
<div class="col-xs-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'HES_ID',
            'REC_NUMERO',
            'ERS_ID',
            'USU_RUT',
            'HES_FECHA_HORA',
            'HES_COMENTARIO',
        ],
    ]) ?>
</div>
</div>
