<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Actualizar Reclamo Sugerencia: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->REC_NUMERO]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="reclamo-sugerencia-update">

      <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
