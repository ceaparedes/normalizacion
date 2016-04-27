<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */
/* @var $form yii\widgets\ActiveForm */
?>

<form class="form-horizontal">
  <div class="page-header"><h1> <?= $this->title ?> </div></h1>

    <?php $form = ActiveForm::begin(['options' =>
                              ['enctype' => 'multipart/form-data',
                              'enableAjaxValidation'=>true,
                            'fieldClass'=> 'col-xs-12 col-sm-3 control-label no-padding-right']
                              ]); ?>

                              <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
                                  <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                  </span> Guardar </label>',
                                 ['class' => 'btn btn-xs btn-white no-radius btn-info',
                              ]) ?>


    <?= $form->field($model, 'TRS_ID')->dropDownList(
        ArrayHelper::map(TIPORECLAMOSUGERENCIA::find()->all(),'TRS_ID','TRS_TIPO'),
        ['prompt'=>'Seleccione el tipo de su Solicitud',
        ]
    )  ?>


    <?= $form->field($model, 'REC_MOTIVO')->textArea(array('rows'=>6)) ?>

    <div class="col-xs-12 col-lg-6">
  <?= $form->field($model, 'files')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    </div>





  <?php ActiveForm::end(); ?>

</div>
