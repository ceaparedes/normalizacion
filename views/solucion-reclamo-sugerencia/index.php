<?php
//use yii tools
use yii\helpers\Html;
use yii\grid\GridView;
// use app models
use app\models\EstadoSolucionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SolucionReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Soluciones a los Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solucion-reclamo-sugerencia-index">
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
            'REC_NUMERO',
            //'SRS_ID',
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


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
