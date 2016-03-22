<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */

$this->title = ' Solicitud de Documento';
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-documento-create">


<div class="col-xs-6" >
    <?= $this->render('_form', [
        'model' => $model,
        'cambios'=>$cambios,
    ]) ?>
</div>
</div>
