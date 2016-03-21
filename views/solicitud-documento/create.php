<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = ' Solicitud de Documento';
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-create">

  

    <?= $this->render('_form', [
        'model' => $model,
        'cambios'=>$cambios,
    ]) ?>
</div>
