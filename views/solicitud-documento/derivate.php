<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\OrigenDocumento;
use app\models\TipoAccionSolicitud;


$this->title = 'Derivar Solicitud de Documento Nº: '. $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivacion Solicitud Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="solicitud-documentos-derivate">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'SOL_ID',
            'oDO.ODO_ORIGEN',
            'tAS.TAS_ACCION',
            'SOL_FUNDAMENTO',
            'eSO.ESO_ESTADO',
        ],
    ]);

        echo DetailView::widget([
        'model' => $cambios,
        'attributes' => [
            'DCS_CAMBIOS'
        ],
    ]);

        echo DetailView::widget([
        'model' => $doc,
        'attributes' => [
            'DOC_CODIGO',
            'DOC_TITULO',
            'DOC_TIPO',
            'oDO.ODO_ORIGEN',
        ],
    ]);

     ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($derivacion, 'USU_RUT')->textInput() ?>
    <?= $form->field($derivacion, 'DSD_CARGO')->textInput() ?>
    <?= $form->field($derivacion, 'DSD_UNIDAD')->textInput() ?>

    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" >
          <i class="glyphicon glyphicon-send"></i>
        </span> Derivar </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
       'data' => [
           'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Derivación?',
           'method' => 'post',
         ],]) ?>

    <?php $form = ActiveForm::end(); ?>


</div>
