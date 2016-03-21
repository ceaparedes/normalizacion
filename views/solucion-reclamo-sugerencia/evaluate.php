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
    
    <?php

      if(!$respuesta){
        echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'REC_NUMERO',
              'rECNUMERO.tRS.TRS_TIPO',
              'rECNUMERO.REC_MOTIVO',
              'USU_RUT',
              'SRS_VISTO_BUENO',
              'SRS_COMENTARIO',
              //'SRS_ANTECEDENTES',
          ],
          ]);

      }else{
        echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'REC_NUMERO',
              'rECNUMERO.tRS.TRS_TIPO',
              'rECNUMERO.REC_MOTIVO',
              'USU_RUT',
              'SRS_VISTO_BUENO',
              'SRS_COMENTARIO',
              'SRS_ANTECEDENTES',
          ],
        ]);
      echo DetailView::widget([
        'model' => $respuesta,
        'attributes' => [
            'DRS_RESPUESTA',
          ],
        ]);

      }

    ?>


    <?= $this->render('_-form', [
        'model' => $model,
        'reclamo'=>$reclamo,
        'respuesta'=>$respuesta,
    ]) ?>
</div>
