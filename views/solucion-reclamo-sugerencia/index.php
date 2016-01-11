<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\EstadoSolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SolucionReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Soluciones a los Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solucion-reclamo-sugerencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Html::a('Ver Reclamos-Sugerencias', ['/reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Ver Solicitudes Derivadas', ['/derivacion-reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'REC_NUMERO',
            'SRS_ID',
            'USU_RUT',
            [
              'attribute'=>'ESR_ID',
              'value'=>'eSR.ESR_ESTADO'
            ],
            'SRS_VISTO_BUENO',
            'SRS_COMENTARIO',
            'SRS_ANTECEDENTES',
            // 'SRS_FECHA_RESPUESTA',
            // 'SRS_FECHA_ENVIO',
            // 'SRS_RESULTADOS',

            ['class' => 'yii\grid\SolucionReclamoSugerenciaActionColumn'],
        ],
    ]); ?>

</div>
