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
?>

<div class="reclamo-sugerencia-search">

  <?php $busqueda = ActiveForm::begin(
      ['action' => ['derivate', 'id' => $model->SRS_ID],
      'method' => 'get']
      );?>
    <div class="bs-callout bs-callout-info">
      <div class="row" >
        <!--para implementar la busqueda se debe cambiar por "nombre"-->
        <div class="form-group align-center">

          <?=
         $busqueda->field($searchModel,'mae_nombre')->textInput(['class'=>'form-horizontal']) ?>
        </div>
        <div class="form-group align-center">
          <?= $busqueda->field($searchModel,'mae_apellido_paterno')->textInput(['class'=>'form-horizontal']) ?>

        </div>
        <div class="panel-footer">
          <center>
        <?= Html::submitButton('<i class="ace-icon fa fa-search bigger-110"></i>Buscar', ['class' => 'btn btn-info', ]) ?>
          </center>
        </div>
      </div>
    </div>


    <!--gridview con los resultados-->
    <h3 id="badges" class="header smaller lighter blue">Resultados</h3>
    <div class="bs-callout bs-callout-info">
      <div class="row" >
        <?php Pjax::begin();?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions'=>[
              'class'=>'encabezadotabla',
              'Pjax'=> true,
              ],

            'columns' => [
              [
                'attribute'=> 'mae_rut',
                'value'=> 'mae_rut',
                'visible'=>false,
              ],
              ['attribute'=>'mae_nombre',
                'value' => 'mae_nombre',
                'label'=> 'Nombre Funcionario',

              ],
              ['attribute'=>'mae_apellido_paterno',
                'value' => 'mae_apellido_paterno',
                'label'=> 'Apellido Paterno',

              ],
              ['attribute'=>'mae_apellido_materno',
                'value' => 'mae_apellido_materno',
                'label'=> 'Apellido Materno',
              ],

              ['class' => 'yii\grid\CheckboxColumn',

              'multiple'=> true,
              ],
            ],
        ]); ?>
      </div>
    </div>
    <?php Pjax::end();?>
<?php $busqueda = ActiveForm::end(); ?>














</div>
