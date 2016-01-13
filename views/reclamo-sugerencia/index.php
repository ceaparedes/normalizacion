<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reclamos y  Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Completar Formulario', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Ver Soluciones', ['/solucion-reclamo-sugerencia/index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=> function($model){
                    if($model->ERS_ID == 8){
                      return ['class'=>'danger'];
                    }if ($model->ERS_ID == 3 || $model->ERS_ID == 5 || $model->ERS_ID == 6 ) {
                      return ['class'=>'success'];
                    }if ($model->ERS_ID == 4) {
                     return ['class'=>'warning'];
                   }if ($model->ERS_ID == 7) {
                     return ['class'=>'info'];
                   }
                },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'REC_NUMERO',
            'USU_RUT',
            'REC_NOMBRE_USUARIO',
            //'Busqueda Tipo Solicitante',
            [
              'attribute'=>'TSR_ID',
              'value'=>'tSR.TSR_TIPO_SOLICITANTE'
            ],
            //'Busqueda Tipo',
            [
              'attribute'=>'TRS_ID',
              'value'=>'tRS.TRS_TIPO'
            ],
            'REC_FECHA',
            // 'REC_REPARTICION',
            //'REC_HORA',
            'REC_MOTIVO',
            //'Busqueda Estado',
            [
              'attribute'=>'ERS_ID',
              'value'=>'eRS.ERS_ESTADO',
            ],
            //'REC_VISTO_BUENO',

            ['class' => 'yii\grid\ReclamoSugerenciaActionColumn'],
        ],
    ]); ?>

</div>
