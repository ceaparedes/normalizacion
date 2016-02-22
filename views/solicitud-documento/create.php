<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = ' Solicitud de Documentos';
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-create">

  <div class="page-header"> <h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
        'docs' => $docs,
    ]) ?>

</div>
