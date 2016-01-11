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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'REC_NUMERO',
            'USU_RUT',
            [
              'attribute'=>'ERS_ID',
              'value'=>'eRS.ERS_ESTADO'
            ],
            'HES_FECHA_HORA',
            'HES_COMENTARIO',
            ['class' => 'yii\grid\HistorialRSActionColumn'],
        ],
    ]); ?>

</div>
