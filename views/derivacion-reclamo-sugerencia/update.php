<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DerivacionReclamoSugerencia */

$this->title = 'Update Derivacion Reclamo Sugerencia: ' . ' ' . $model->DRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DRS_ID, 'url' => ['view', 'id' => $model->DRS_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="derivacion-reclamo-sugerencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
