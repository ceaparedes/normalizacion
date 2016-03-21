<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialVersionDocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Version Documentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-version-documento-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historial Version Documento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'HVD_ID',
            'USU_RUT',
            'DOC_CODIGO',
            'VER_ID',
            'HVD_FECHA_HORA',
            // 'HVD_COMENTARIO',
            // 'HVD_VISTO_BUENO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
