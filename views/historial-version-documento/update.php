<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialVersionDocumento */

$this->title = 'Update Historial Version Documento: ' . ' ' . $model->HVD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Historial Version Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HVD_ID, 'url' => ['view', 'id' => $model->HVD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historial-version-documento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
