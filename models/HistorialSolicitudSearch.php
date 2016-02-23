<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialSolicitud;

/**
 * HistorialSolicitudSearch represents the model behind the search form about `app\models\HistorialSolicitud`.
 */
class HistorialSolicitudSearch extends HistorialSolicitud
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HSO_ID', 'ESO_ID'], 'integer'],
            [['USU_RUT', 'SOL_ID', 'HSO_FECHA_HORA', 'HSO_COMENTARIO'], 'safe'],
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
        $query = HistorialSolicitud::find();

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
            'HSO_ID' => $this->HSO_ID,
            'ESO_ID' => $this->ESO_ID,
            'HSO_FECHA_HORA' => $this->HSO_FECHA_HORA,
        ]);

        $query->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'SOL_ID', $this->SOL_ID])
            ->andFilterWhere(['like', 'HSO_COMENTARIO', $this->HSO_COMENTARIO]);

        return $dataProvider;
    }
}
