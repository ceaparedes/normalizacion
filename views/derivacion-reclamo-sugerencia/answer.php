<?php

//use Yii tools
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\db\QueryTrait;
//use app Models
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoSolucionReclamoSugerencia;
use app\models\DerivacionReclamoSugerencia;
use app\models\ReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\Adjuntos;


/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Respuesta a la Solicitud Derivada Nº: '. $model->DRS_ID;
$this->params['breadcrumbs'][] = ['label' => 'Derivaciones Realizadas a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Nº' .$model->SRS_ID, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Respuesta';
?>

<div class="Derivacion-reclamo-sugerencia-answer">

  <?php $form = ActiveForm::begin(['options' =>
                                ['enctype' => 'multipart/form-data',
                                'enableAjaxValidation'=>true,
                                'id'=>'answer-form',
                                'name'=>'answer-form',
                                ]
                                ]); ?>
  <div class="box-header margenb5 pull-right">
    <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
        <span class="btn btn-xs btn-info no-radius">
          <i class="glyphicon glyphicon-send"></i>
        </span> Responder </label>',
       ['class' => 'btn btn-xs btn-white no-radius btn-info',
      'data' => [
     'confirm' => 'Una vez enviada la respuesta no se podrán efectuar cambios, ¿Está seguro de la respuesta escrita?',
     'method' => 'post',
   ],]) ?>
  </div>



<div class="page-header"><h1> <?= $this->title ?></h1></div>

<div class="bs-callout bs-callout-info">
  <div class="row" >
    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sRS.rECNUMERO.REC_NUMERO',
            'sRS.rECNUMERO.tRS.TRS_TIPO',
            'sRS.rECNUMERO.REC_MOTIVO',
            'sRS.SRS_ANTECEDENTES',
        ],
    ]) ?>
    <?php
    if($contador_sac_sap>0){
      $query = new Query;
      $query->select ('ADJ_ID')
          ->from('ADJUNTOS')
          ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Derivacion-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
      $query = $query->All();
      for ($i=0; $i <$contador_sac_sap ; $i++) {
        $adj = new Adjuntos();
        $adj = $adj->findOne($query[$i]);

        echo DetailView::widget([
        'model' => $adj,
        'attributes' => [

          [
            'attribute'=>'ADJ_URL',
            'format'=>'raw',
            'label'=>'SAC-SAP a Completar',
            'value'=>Html::a('Presione aquí para descargar su SAC-SAP', $adj->ADJ_URL, ['target' => '_blank']),

          ],

        ],
      ]);
      }
    }

    ?>
  </div>
</div>

<div class="bs-callout bs-callout-info">
  <div class="row" >

    <div class="col-xs-12 col-lg-7">
    <?= $form->field($model, 'DRS_RESPUESTA')->textArea(['rows' =>3],['class' => 'form-horizontal','required'=>true]) ?>
    </div>

    <div class="col-xs-12 col-lg-6">
  <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>
    </div>

<?php
  //$jss = "if ( $('#derivacionreclamosugerencia-drs_respuesta').length ){ alert('holahola')}";

  $js = '$("#answer-form").submit(function () {
    if(($("#derivacionreclamosugerencia-drs_respuesta").val().length < 1) && $("#derivacionreclamosugerencia-files").val().length < 1) {
        alert("Debe Completar Ambos Campos");
        return false;
    }
    return true;
});';

  $this->registerJs($js);
?>


    <?php $form = ActiveForm::end(); ?>
  </div>
  </div>
</div>
