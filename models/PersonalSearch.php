<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;
use app\models\Personal;

class PersonalSearch extends Personal
{

  public function scenarios()
  {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
  }

  public function search($params)
  {
      /*
      $nombre = NULL;
      $apellido = NULL;
      $sp = 'Creditotest..sp_WEB_BUSCAR_PERSONAL_PARA_HONORARIOS ';
      $comando = Yii::$app->dbcreditotest->createCommand($sp)->queryAll();
      */
      $query = PersonalSearch::find();

      /*

      $comando = Yii::$app->dbcreditotest->createCommand($sp)->queryAll();
      */
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'sort'=>false,
      ]);

      $this->load($params);

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          $query->where('0=1');
          return $dataProvider;
      }

      $query->andFilterWhere(['like', 'mae_nombre', $this->mae_nombre])
          ->orFilterWhere(['like', 'mae_apellido_paterno', $this->mae_apellido_paterno])
          ->orFilterWhere(['like', 'mae_apellido_materno', $this->mae_apellido_paterno]);


      return $dataProvider;
  }







}
