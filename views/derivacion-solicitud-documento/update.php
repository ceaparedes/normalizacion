<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumento */

$this->title = 'Update Derivacion Solicitud Documento: ' . ' ' . $model->DSD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DSD_ID, 'url' => ['view', 'id' => $model->DSD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="derivacion-solicitud-documento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
