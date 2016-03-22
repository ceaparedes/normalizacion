<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialVersionDocumento */

$this->title = $model->HVD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Historial Version Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-version-documento-view">




<div class="col-xs-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'HVD_ID',
            'USU_RUT',
            'DOC_CODIGO',
            'VER_ID',
            'HVD_FECHA_HORA',
            'HVD_COMENTARIO',
            'HVD_VISTO_BUENO',
        ],
    ]) ?>
</div>
</div>
