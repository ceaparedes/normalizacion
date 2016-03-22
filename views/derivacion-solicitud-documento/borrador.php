<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BorradorDocumento */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Subir Borrador Documento';
$this->params['breadcrumbs'][] = ['label' => 'Borrador Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrador-documento-create">


<div class="borrador-documento-form">


  <?php echo DetailView::widget([
    'model' => $solicitud,
    'attributes' => [
        'SOL_ID',
        'oDO.ODO_ORIGEN',
        'tAS.TAS_ACCION',
        'SOL_FUNDAMENTO',
    ],
]);

      if($cambios){

        echo DetailView::widget([
          'model' => $cambios,
          'attributes' => [
              'DCS_CAMBIOS',
          ],
      ]);}
?>

<div class="col-xs-6" >
    <?php $form = ActiveForm::begin(['options' =>
                                      ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'DSD_RESPUESTA')->textArea() ?>

    <?= $form->field($borrador, 'file')->fileInput()  ?>


    <div class="form group">
    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
          <i class="glyphicon glyphicon-floppy-disk"></i>
        </span> Guardar </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
    ]) ?>
  </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
