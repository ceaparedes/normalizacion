<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\TipoReclamoSugerencia;
use backend\models\TipoSolicitanteReclamoSugerencia;
use backend\models\EstadoReclamoSugerencia;
use backend\models\EstadoSolucionReclamoSugerencia;
use frontend\models\DerivacionReclamoSugerencia;

/* @var $this yii\web\View */
/* @var $model frontend\models\ReclamoSugerencia */

$this->title = 'Evaluacion de Respuesta al Formulario Nº: ' . $model->REC_NUMERO;
$this->params['breadcrumbs'][] = ['label' => 'Soluciones a los Reclamos y Sugerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $reclamo->REC_NUMERO, 'url' => ['reclamo-sugerencia/view', 'id' => $reclamo->REC_NUMERO]];
$this->params['breadcrumbs'][] = 'Autorizar';
?>

<div class="solucion-reclamo-sugerencia-create">
<div class="col-xs-6" >
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


      echo DetailView::widget([
        'model' => $respuesta,
        'attributes' => [
            'DRS_RESPUESTA',
          ],
        ]);


    ?>
  </div>

<div class="col-xs-6" >

    <?php

    if(Yii::$app->user->identity->tipo_usuario == 'ADMINISTRATIVO'){

     $this->render('_-form', [
        'model' => $model,
        'reclamo'=>$reclamo,
        'respuesta'=>$respuesta,
    ]);
  }elseif($reclamo->USU_RUT == Yii::$app->user->identity->rut) {
    $this->render('_--form', [
       'model' => $model,
       'reclamo'=>$reclamo,
       'respuesta'=>$respuesta,
   ]);
  }


    ?>
</div>
</div>
