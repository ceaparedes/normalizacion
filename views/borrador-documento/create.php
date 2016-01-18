<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumento */

$this->title = 'Create Borrador Documento';
$this->params['breadcrumbs'][] = ['label' => 'Borrador Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrador-documento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
