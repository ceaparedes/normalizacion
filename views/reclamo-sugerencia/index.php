<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reclamos y  Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-index">

      
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<label class="box-title pull-right margenbtnsuperior dark">
            <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
              <i class="glyphicon  glyphicon-pencil"></i>
            </span> Completar Formulario</label>', ['create'], ['class' => 'btn btn-xs btn-white no-radius btn-info']) ?>

    </p>
<div class="bs-callout bs-callout-info">
<div class="box-body table-responsive no-padding table-bordered siempre_responsivo">

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
            //['class' => 'yii\grid\SerialColumn'],

            'REC_NUMERO',
            //'USU_RUT',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  </div>
</div>
</div>
