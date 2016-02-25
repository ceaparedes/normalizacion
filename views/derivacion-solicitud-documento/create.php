<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DerivacionSolicitudDocumento */

$this->title = 'Derivar Solicitud de Documento';
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="derivacion-solicitud-documento-create">

    <div class="page header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
