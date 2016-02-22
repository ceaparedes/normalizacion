<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoAccionSolicitud;

/**
 * TipoAccionSolicitudSearch represents the model behind the search form about `app\models\TipoAccionSolicitud`.
 */
class TipoAccionSolicitudSearch extends TipoAccionSolicitud
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ODO_ID', 'TAS_ID'], 'integer'],
            [['TAS_ACCION'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TipoAccionSolicitud::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ODO_ID' => $this->ODO_ID,
            'TAS_ID' => $this->TAS_ID,
        ]);

        $query->andFilterWhere(['like', 'TAS_ACCION', $this->TAS_ACCION]);

        return $dataProvider;
    }
}
