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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Volver a menú Anterior', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

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
