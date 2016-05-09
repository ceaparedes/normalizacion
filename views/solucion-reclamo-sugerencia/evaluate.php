<?php
//use Yii tools
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\db\QueryTrait;
//use app Model
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\EstadoSolucionReclamoSugerencia;
use app\models\DerivacionReclamoSugerencia;
use app\models\Adjuntos;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Evaluacion de Respuesta al Formulario Nº: ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Soluciones a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $reclamo->REC_NUMERO, 'url' => ['reclamo-sugerencia/view', 'id' => $reclamo->REC_NUMERO]];
$this->params['breadcrumbs'][] = 'Evaluar Respuesta Entregada';
?>
<?php $form = ActiveForm::begin(); ?>

<div class="box-header margenb5 pull-right">
<?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
    <span class="btn btn-xs btn-info no-radius" id="reclamo-sugerencia-create" onclick="submit">
      <i class="glyphicon glyphicon-pencil"></i>
    </span> Evaluar </label>',
   ['class' => 'btn btn-xs btn-white no-radius btn-info',
     ]) ?>
</div>

<div class="page-header"><h1> <?= $this->title ?></h1></div>

<div class="solucion-reclamo-sugerencia-evaluate">

  <h3 id="badges" class="header smaller lighter blue">Antecedentes de la Solicitud</h3>
  <div class="bs-callout bs-callout-info">
    <div class="row" >

    <?php

        echo DetailView::widget([
          'model' => $reclamo,
          'attributes' => [
              'REC_NUMERO',
              'tRS.TRS_TIPO',
              'eRS.ERS_ESTADO',
              'REC_MOTIVO',
          ],
        ]);

        echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'SRS_COMENTARIO',
              'SRS_ANTECEDENTES',
              'SRS_SERVICIO_NO_CONFORME',

          ],
        ]);
        echo "</div>";
      echo "</div>";

      echo '<h3 id="badges" class="header smaller lighter blue">Respuestas Entregadas</h3>';

      echo '<div class="bs-callout bs-callout-info">';
      echo '<div class="row">';

      if($derivaciones>0){
        $query = new Query;
        $query->select ('DRS_ID')
            ->from('DERIVACION_RECLAMO_SUGERENCIA')
            ->where('SRS_ID=:solucion', [':solucion' => $model->SRS_ID]);
        $query = $query->All();
        for ($i=0; $i <$derivaciones ; $i++) {
          $respuesta = new DerivacionReclamoSugerencia();
          $respuesta = $respuesta->findOne($query[$i]);

          echo DetailView::widget([
            'model' => $respuesta,
            'attributes' => [
                'DRS_NOMBRE',
                'DRS_CARGO',
                'DRS_FECHA_RESPUESTA',
                'DRS_RESPUESTA',
              ],
            ]);
        }
      }

      if($count_adj_respuestas >0 ){
        echo '<h3 id="badges" class="header smaller lighter blue">SAC-SAP  Completado por el Usuario</h3>';
        //muestra el enlace al Archivo adjunto
        $query = new Query;
        $query->select ('ADJ_ID')
            ->from('ADJUNTOS')
              ->where("REC_NUMERO=:reclamo AND ADJ_TIPO = 'Respuesta-Reclamo-Sugerencia'" , [':reclamo' => $reclamo->REC_NUMERO]);
        $query = $query->All();

        for ($i=0; $i <$count_adj_respuestas ; $i++) {
          $adj = new Adjuntos();
          $adj = $adj->findOne($query[$i]);
          echo DetailView::widget([
          'model' => $adj,
          'attributes' => [

            [
              'attribute'=>'ADJ_URL',
              'format'=>'raw',
              'label'=>'SAC-SAP Adjunto',
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

    <div class="col-xs-12 col-lg-7">
      <?= $form->field($reclamo, 'REC_VISTO_BUENO')->radioList(['Autorizado'=>'Autorizar','Rechazado'=>'Rechazar']); ?>
    </div>
  </div>
</div>


<?php $form = ActiveForm::end(); ?>
</div>
