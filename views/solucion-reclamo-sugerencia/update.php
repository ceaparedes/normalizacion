<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SolucionReclamoSugerencia */

$this->title = 'Update Solucion Reclamo Sugerencia: ' . ' ' . $model->SRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solucion Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SRS_ID, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="solucion-reclamo-sugerencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
