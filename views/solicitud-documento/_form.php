<?php
//use yii tools
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

//use models
use app\models\OrigenDocumento;
use app\models\TipoAccionSolicitud;


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

    <?php
    $provincia = ArrayHelper::map(OrigenDocumento::find()->all(), 'ODO_ID', 'ODO_ORIGEN');
    echo $form->field($model, 'ODO_ID')->dropDownList(
        $provincia,
        [
            'prompt'=>'Por favor elija una',
            'onchange'=>'
                            $.get( "'.Url::toRoute('dependent-dropdown/origen-documento').'", { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'ODO_ID').'" ).html( data );
                                }
                            );
                        '
        ]
    );
    ?>

    <?php echo $form->field($model, 'TAS_ID')->dropDownList(array(),
        [
            'prompt'=>'Por favor elija uno',
            'onchange'=>'
                            $.get( "'.Url::toRoute('dependent-dropdown/tipo-accion-solicitud').'", { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'TAS_ID').'" ).html( data );
                                }
                            );
                        '
        ]
    ); ?>

    <?php
    if ($model->isNewRecord)
        echo $form->field($model, 'ODO_ID')->dropDownList(['prompt'=>'Por favor elija una']);
    else
    {
        $localidad = ArrayHelper::map(Localidades::find()->where(['ODO_ID' =>$model->localidad_id])->all(), 'TAS_ID', 'TAS_ACCION');
        echo $form->field($model, 'TAS_ID')->dropDownList($localidad);
    }
    ?>


<!--
    <?= $form->field($model, 'ODO_ID')->dropDownList(
        ArrayHelper::map(OrigenDocumento::find()->all(),'ODO_ID','ODO_ORIGEN'),
        ['prompt'=>'Seleccione el tipo de Documento',
        'onChange'=>'
            $.post( "index.php?r=TipoAccionSolicitud/lists&id='.'"+$(this).val(), function(data){
              $( "select#ORIGEN_DOCUMENTO.TAS_ID" ).html( data );}
          );']
    )  ?>

    <?= $form->field($model, 'TAS_ID')->dropDownList(
        ArrayHelper::map(TipoAccionSolicitud::find()->all(),'TAS_ID','TAS_ACCION'),
        ['prompt'=>'Seleccione la Accion',

        ]
    )  ?> -->

    <?= $form->field($model, 'DOC_CODIGO')->textInput() ?>

    <?= $form->field($model, 'VER_ID')->textInput() ?>



    <?= $form->field($model, 'SOL_FUNDAMENTO')->textArea() ?>

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
