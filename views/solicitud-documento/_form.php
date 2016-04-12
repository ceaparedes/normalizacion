<?php
//use yii tools
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

//use models
use app\models\OrigenDocumento;
use app\models\TipoAccionSolicitud;
use app\models\Documento;

use app\models\VersionDocumento;


/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-documento-form">

    <?php $form = ActiveForm::begin(['options' =>
                              ['enctype' => 'multipart/form-data',
                              'enableAjaxValidation'=>true]]); ?>

    <?= $form->field($model, 'USU_RUT')->textInput() ?>

    <?= $form->field($model, 'SOL_UNIDAD')->textInput() ?>

    <?= $form->field($model,'ODO_ID')->dropDownList(
                                ArrayHelper::map( OrigenDocumento::find()->all(), 'ODO_ID', 'ODO_ORIGEN'),
                                [
                                    'prompt'=>'Seleccione el Origen',
                                    'onchange'=>'
                                        $.post( "index.php?r=documento/lists&id='.'"+$(this).val(), function( data ) {
                                            $( "select#solicituddocumento-doc_codigo" ).html( data );
                                        }),
                                        $.post( "index.php?r=tipo-accion-solicitud/lists&id='.'"+$(this).val(), function( data ) {
                                            $( "select#solicituddocumento-tas_id" ).html( data );
                                        });'
                                ]); ?>

      <?= $form->field($model, 'DOC_CODIGO')->widget(Select2::classname(), [
      'data' => ArrayHelper::map(Documento::find()->all(),'DOC_CODIGO','DOC_TITULO'),
      'language' => 'es',
      'options' => ['placeholder' => 'Seleccione el Documento '],
      'pluginOptions' => [
          'allowClear' => true
            ],
          ]);
      ?>



    <?= $form->field($model, 'TAS_ID')->dropDownList(
        ArrayHelper::map(TipoAccionSolicitud::find()->all(),'TAS_ID','TAS_ACCION'),
        ['prompt'=>'Seleccione la Accion',]
    )  ?>




    <?= $form->field($model, 'SOL_FUNDAMENTO')->textArea(array('rows'=>3)) ?>

    <?= $form->field($cambios, 'DCS_CAMBIOS')->textArea(array('rows'=>6)) ?>

    <?= $form->field($model, 'file')->fileInput() ?>



    <div class="form-group">
      <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
          <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
            <i class="glyphicon glyphicon-floppy-disk"></i>
          </span> Guardar </label>',
         ['class' => 'btn btn-xs btn-white no-radius btn-info',
      ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
