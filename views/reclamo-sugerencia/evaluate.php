<?php
//use yii tools
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\db\QueryTrait;

//use models
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\Adjuntos;

$this->title = 'Evaluación a la Solicitud: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->REC_NUMERO]];
$this->params['breadcrumbs'][] = 'Evaluar';
?>

<?php $form = ActiveForm::begin(['enableAjaxValidation'=>true]); ?>

<div class="reclamo-sugerencia-evaluate">
  <div class="box-header margenb5 pull-right">
  <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-evaluate">
        <i class="glyphicon glyphicon-pencil"></i>
      </span> Evaluar </label>',
     ['class' => 'btn btn-xs btn-white no-radius btn-info',
     'data' => [
       'confirm' => 'Una vez enviada la respuesta no se podrán efectuar cambios, ¿Está seguro de enviar la Evaluación?',
       'method' => 'post',
     ],]) ?>
  </div>

<div class="page-header"><h1> <?= $this->title ?></h1></div>

<div class="bs-callout bs-callout-info">
  <div class="row" >
  <?=DetailView::widget([
      'model' => $model,
      'attributes' => [
          'REC_NUMERO',
          'REC_NOMBRE_USUARIO',
          'tRS.TRS_TIPO',
          'REC_FECHA',
          //'REC_REPARTICION', no mostrat por si es alumno.
          'eRS.ERS_ESTADO',
          'REC_MOTIVO',
      ],
  ]) ?>

  <?php
  //si existe el adjunto
  if($contador >0){
    //muestra el enlace al Archivo adjunto
    $query = new Query;
    $query->select ('ADJ_ID')
        ->from('ADJUNTOS')
        ->where('REC_NUMERO=:reclamo', [':reclamo' => $model->REC_NUMERO]);
    $query = $query->All();

    for ($i=0; $i <$contador ; $i++) {
      $adj = new Adjuntos();
      $adj = $adj->findOne($query[$i]);
      echo DetailView::widget([
      'model' => $adj,
      'attributes' => [

        [
          'attribute'=>'ADJ_URL',
          'format'=>'raw',
          'value'=>Html::a('Vea aquí el Archivo Adjunto', $adj->ADJ_URL, ['target' => '_blank']),

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


  <div class="col-xs-12 col-lg-6 ">
<?= $form->field($solucion, 'SRS_VISTO_BUENO')->radioList(array('Autorizado'=>'Autorizar','Rechazado'=>'Rechazar')); ?>
  </div>

<div class="col-xs-12 col-lg-7 ">
<?= $form->field($solucion, 'SRS_COMENTARIO')->textArea(array('rows'=>4)) ?>
  </div>
</div>






<?php $form = ActiveForm::end(); ?>

</div>
