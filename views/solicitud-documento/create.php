<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = ' Solicitud de Documento';
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-create">

  <div class="page-header"> <h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
        'docs' => $docs,
    ]) ?>

</div>
