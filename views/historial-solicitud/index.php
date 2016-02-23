<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialSolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial evolutivo de Solicitudes de Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-solicitud-index">

      <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


<div class="box-body table-responsive no-padding table-bordered siempre_responsivo">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'HSO_ID',
            'ESO_ID',
            'USU_RUT',
            'SOL_ID',
            'HSO_FECHA_HORA',
            // 'HSO_COMENTARIO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
