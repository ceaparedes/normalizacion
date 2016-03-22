<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BorradorDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Borrador Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrador-documento-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SOL_ID',
            ['attribute' => 'EBD_ID',
             'value'=>'eBD.EBD_ESTADO'
            ],
            ['attribute' => 'SOL_ID',
            'value'=>'sOL.tAS.TAS_ACCION',
            'label'=>'Accion Realizada'],
            'BDO_FECHA_ENVIO',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
