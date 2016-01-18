<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumento */

$this->title = 'Update Borrador Documento: ' . ' ' . $model->BDO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Borrador Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BDO_ID, 'url' => ['view', 'id' => $model->BDO_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="borrador-documento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
