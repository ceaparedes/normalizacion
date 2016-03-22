<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialSolicitud */

$this->title = $model->HSO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Historial de Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-solicitud-view">

<div class="col-xs-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'HSO_ID',
            'ESO_ID',
            'USU_RUT',
            'SOL_ID',
            'HSO_FECHA_HORA',
            'HSO_COMENTARIO',
        ],
    ]) ?>
</div>
</div>
