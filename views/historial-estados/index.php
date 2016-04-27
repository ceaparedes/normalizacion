<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HistorialEstadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Evolutivo de Reclamos y Suregencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-estados-index">
  <div class="page-header"><h1> <?= $this->title ?></h1></div>
    <div class="col-xs-6" >
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <div class="box-body table-responsive no-padding table-bordered">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'REC_NUMERO',
            'USU_RUT',
            'eRS.ERS_ESTADO',

            'HES_FECHA_HORA',
            'HES_COMENTARIO',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
