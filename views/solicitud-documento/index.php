<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitud Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SOL_ID',
            'USU_RUT',
            // 'ODO_ID',
            [
              'attribute'=> 'TAS_ID',
              'value'=>'tAS.TAS_ACCION'
            ],
            // 'SIS_ID',
            // 'SRS_ID',
            'SOL_FECHA',
            // 'SOL_UNIDAD',
            'SOL_FUNDAMENTO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
