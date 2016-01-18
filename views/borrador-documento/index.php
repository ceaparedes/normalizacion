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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Borrador Documento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'BDO_ID',
            'EBD_ID',
            'SOL_ID',
            'BDO_FECHA_ENVIO',
            'BDO_FECHA_RESPUESTA',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
