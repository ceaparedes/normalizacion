<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DerivacionReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Derivaciones Realizadas a los Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-reclamo-sugerencia-index">

      <div class="page-header"><h1> <?= $this->title ?></h1></div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="bs-callout bs-callout-info">
<div class="box-body table-responsive no-padding table-bordered">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'headerRowOptions'=>[
          'class'=>'encabezadotabla',
        ],

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
