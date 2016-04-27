<?php
//use yii tools
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\widgets\Pjax;

//use models
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\EstadoSolucionReclamoSugerencia;
use app\models\DerivacionReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\Personal;
use app\models\PersonalSearch;


$this->title = 'Derivar Solicitud: ' . ' ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Reclamo Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->REC_NUMERO, 'url' => ['view', 'id' => $model->SRS_ID]];
$this->params['breadcrumbs'][] = 'Derivar';
?>

<div class="solucion-reclamo-sugerencia-derivate">

  <?php $form = ActiveForm::begin();?>

  <div class="box-header margenb5 pull-right">
  <?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius">
        <i class="glyphicon glyphicon-send"></i>
      </span> Derivar </label>',
     ['class' => 'btn btn-xs btn-white no-radius btn-info',
     'data' => [
         'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Derivación?',
         'method' => 'post',
       ],
       'name'=>'derivar',
       ]) ?>
  </div>
  <div class="page-header"><h1> <?= $this->title ?></h1></div>
<!--datos completados en procesos anteriores-->
  <div class="bs-callout bs-callout-info">
    <div class="row" >
      <?=DetailView::widget([
          'model' => $model,
          'attributes' => [
              'REC_NUMERO',
              'rECNUMERO.tRS.TRS_TIPO',
              'rECNUMERO.eRS.ERS_ESTADO',
              'SRS_COMENTARIO',
              'rECNUMERO.REC_MOTIVO',
          ],
      ]) ?>
    </div>
  </div>

  <div class="bs-callout bs-callout-info">
    <div class="row" >
      <div class="col-xs-12 col-lg-7 ">
        <?= $form->field($model, 'SRS_ANTECEDENTES')->textArea(['rows'=>4, 'class'=>'autosize-transition form-control']) ?>
      </div>

      <div class="col-xs-12 col-lg-6 ">
        <?= $form->field($model, 'SRS_SERVICIO_NO_CONFORME')->radioList(['Si'=>'Si','No'=>'No'],['class' => 'form-horizontal']); ?>
      </div>

      <div class="col-xs-12 col-lg-6">
        <?= $form->field($derivacion, 'files[]')->fileInput(['multiple' => true]) ?>
      </div>
    </div>
  </div>
  <!--los datos del funciorario deben ser recepciona-->
<?php $form = ActiveForm::end(); ?>
<!--debe quedar aqui el ActiveForm END ya que o si no el boton buscar hace submit-->
<?= $this->render('_personalSearch', [
    'searchModel' => $searchModel,
    'dataProvider'=> $dataProvider,
    'model'=>$model,
]) ?>


</div>
