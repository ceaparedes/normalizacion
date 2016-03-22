<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


$this->title = 'Solicitud de Documentos Nº: ' . ' ' . $model->SOL_ID;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud de Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SOL_ID, 'url' => ['view', 'id' => $model->SOL_ID]];
$this->params['breadcrumbs'][] = 'Evaluar';
 ?>

 <div class="solicitud-documento-evaluate">



<?php
 echo DetailView::widget([
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
 ]);
}

echo DetailView::widget([
 'model' => $model,
 'attributes' => [
     'BDO_ID',
     'eBD.EBD_ESTADO',
     'BDO_FECHA_ENVIO',
 ],
]);

if($adjunto){
//muestra el enlace al Archivo adjunto
echo DetailView::widget([
'model' => $adjunto,
'attributes' => [
 [
   'attribute'=>'ADJ_URL',
   'format'=>'raw',
   'value'=>Html::a('Borrador Documento', $adjunto->ADJ_URL, ['target' => '_blank']),

 ],],
]);
 }
?>
<div class="col-xs-6" >
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'visto_bueno_normalizacion')->radioList(array('Aprobado'=>'Aprobar','Rechazado'=>'Rechazar')); ?>

<?= Html::submitButton('<label class="box-title pull-right margenbtnsuperior dark">
    <span class="btn btn-xs btn-info no-radius" id="solicitud-documento-evaluate" onclick="submit">
      <i class="glyphicon glyphicon-pencil"></i>
    </span> Evaluar </label>',
   ['class' => 'btn btn-xs btn-white no-radius btn-info',
   'data' => [
       'confirm' => 'Una vez enviada la Petición no se podrán efectuar cambios, ¿Está seguro de enviar la Evaluación?',
       'method' => 'post',
     ],]) ?>

  <?php $form = ActiveForm::end(); ?>
</div>
</div>
