<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\EstadoDerivacionReclamoSugerencia;
use frontend\models\SolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DerivacionReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Derivaciones Realizadas a los Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-reclamo-sugerencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Ver Reclamos - Sugerencias', ['reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Ver soluciones', ['solucion-reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DRS_ID',
            [
              'attribute'=>'SRS_ID',
              'value'=>'sRS.REC_NUMERO'
            ],
            [
              'attribute'=>'EDR_ID',
              'value'=>'eDR.EDR_ESTADO'
            ],
            'USU_RUT',

            'DRS_CARGO',
            // 'DRS_UNIDAD',
            // 'DRS_FECHA_DERIVACION',
            // 'DRS_FECHA_RESPUESTA',
            // 'DRS_RESPUESTA',

            ['class' => 'yii\grid\DerivacionActionColumn'],
        ],
    ]); ?>

</div>
