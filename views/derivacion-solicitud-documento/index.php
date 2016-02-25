<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DerivacionSolicitudDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes de Documentos Derivadas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-solicitud-documento-index">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DSD_ID',
            'EDS_ID',
            'SOL_ID',
            'USU_RUT',
            'DSD_CARGO',
            // 'DSD_UNIDAD',
            // 'DSD_FECHA_DERIVACION',
            // 'DSD_FECHA_RESPUESTA',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
