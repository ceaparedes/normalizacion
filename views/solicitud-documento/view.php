<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SOL_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SOL_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOL_ID',

            'eSO.ESO_ESTADO',
            'USU_RUT',
            'oDO.ODO_ORIGEN',
            'tAS.TAS_ACCION',
            'SOL_FECHA',
            'SOL_UNIDAD',
            'SOL_FUNDAMENTO',
        ],
    ]) ?>

</div>
