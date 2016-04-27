<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ReclamoSugerenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reclamos y  Sugerencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reclamo-sugerencia-index">
  <?php
    if(Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO')
    {
      echo '<div class="box-header margenb5 pull-right">';

      echo Html::a('<label class="box-title pull-right margenbtnsuperior dark">
      <span class="btn btn-xs btn-info no-radius">
      <i class="glyphicon glyphicon-pencil"></i>
      </span> Completar Formulario en Blanco</label>', ['createblank'], ['class' => 'btn btn-xs btn-white no-radius btn-info']) ;

      echo "</div>";
    } ?>
    <div class="page-header"><h1> <?= $this->title ?></h1></div>

<?php
  //agregar if para que el que pueda ver esto sea el JDNYC

    echo $this->render('_search', ['model' => $searchModel]);

 ?>
<div class="bs-callout bs-callout-info">
<div class="box-body table-responsive no-padding table-bordered">

  <h3 id="badges" class="header smaller lighter blue">Solicitudes Presentadas</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,


        'headerRowOptions'=>[
          'class'=>'encabezadotabla',
        ],

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'REC_NUMERO',
            //'USU_RUT',
            'REC_NOMBRE_USUARIO',
            //'Busqueda Tipo Solicitante',
            'tSR.TSR_TIPO_SOLICITANTE',
            //'Busqueda Tipo',
            'tRS.TRS_TIPO',

            'REC_FECHA',
            // 'REC_REPARTICION',
            //'REC_HORA',
            'REC_MOTIVO',
            //'Busqueda Estado',
            'eRS.ERS_ESTADO',
            //'REC_VISTO_BUENO',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  </div>
</div>
</div>
