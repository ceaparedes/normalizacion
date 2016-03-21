<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HistorialVersionDocumento */

$this->title = 'Create Historial Version Documento';
$this->params['breadcrumbs'][] = ['label' => 'Historial Version Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-version-documento-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
