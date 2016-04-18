<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;



/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Formulario Reclamos y Sugerencias';
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['options' =>
                              ['enctype' => 'multipart/form-data',
                              'enableAjaxValidation'=>true,
                            ]
                              ]); ?>
    <div class="box-header margenb5 pull-right">
      <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
          <i class="glyphicon glyphicon-floppy-disk"></i>
        </span> Guardar </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
    ]) ?> </div>
     <div class="page-header"><h1> <?= $this->title ?></h1></div>

<!--Comienzo Formularios -->
    <div class="bs-callout bs-callout-info">
      <div class="row">
        <form name="reclamo-sugerencia-create" method action class="form-horizontal">

      <div class="col-xs-12 col-lg-6">
    <?= $form->field($model, 'TRS_ID')->dropDownList(
        ArrayHelper::map(TIPORECLAMOSUGERENCIA::find()->all(),'TRS_ID','TRS_TIPO'),
        ['prompt'=>'Seleccione el tipo de su Solicitud',
          'class' => 'form-horizontal']
          )  ?>
        </div>

      <div class="col-xs-12 col-lg-7">
    <?= $form->field($model, 'REC_MOTIVO')->textArea(['rows'=> 4,'class'=>'autosize-transition form-control']) ?>
      </div>

      <div class="col-xs-12 col-lg-6">
    <?= $form->field($model, 'file')->fileInput() ?>
      </div>

        </form>
      </div>
  </div>

  <?php ActiveForm::end(); ?>
<!--end Formularios-->




<!--
  <?=
     $this->render('_form2rs', [
      'model' => $model,
    ]);

    ?>
  -->
</div>
