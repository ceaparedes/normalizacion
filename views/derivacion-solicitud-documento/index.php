<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\EstadoDerivacionSolicitudDocumento;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DerivacionSolicitudDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes de Documentos Derivadas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-solicitud-documento-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SOL_ID',
            [
              'attribute'=>'EDS_ID',
              'value'=>'eDS.EDS_ESTADO'
            ],
            'USU_RUT',
            'DSD_CARGO',
            // 'DSD_UNIDAD',
            'DSD_FECHA_DERIVACION',
            [
              'attribute'=>'SOL_ID',
              'value'=>'sOL.tAS.TAS_ACCION',
              'label'=>'Accion a Realizar'
            ],
            // 'DSD_FECHA_RESPUESTA',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
