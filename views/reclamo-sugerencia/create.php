<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Formulario Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-create">


<div class="col-xs-6" >
    <?php


      echo $this->render('_form2rs', [
        'model' => $model,
      ]);


      /*if()usuario distinto de JDNYC
      echo $this->render('_form2rs', [
        'model' => $model,
      ]);

      else
      echo $this->render('_form', [
        'model' => $model,
      ]);

      */

      ?>
</div>

</div>
