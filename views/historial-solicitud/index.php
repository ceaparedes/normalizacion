<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialSolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Solicituds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-solicitud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historial Solicitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'HSO_ID',
            'ESO_ID',
            'USU_RUT',
            'SOL_ID',
            'HSO_FECHA',
            // 'HSO_COMENTARIO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
