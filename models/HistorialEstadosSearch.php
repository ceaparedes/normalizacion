<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialEstados;
use app\models\EstadoReclamoSugerencia;

/**
 * HistorialEstadosSearch represents the model behind the search form about `frontend\models\HistorialEstados`.
 */
class HistorialEstadosSearch extends HistorialEstados
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HES_ID'], 'integer'],
            [['REC_NUMERO', 'ERS_ID', 'USU_RUT', 'HES_FECHA_HORA', 'HES_COMENTARIO'], 'safe'],
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
        $query = HistorialEstados::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('eRS');
        $query->andFilterWhere([
            'HES_ID' => $this->HES_ID,
            'HES_FECHA_HORA' => $this->HES_FECHA_HORA,
        ]);

        $query->andFilterWhere(['like', 'REC_NUMERO', $this->REC_NUMERO])
            ->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'HES_COMENTARIO', $this->HES_COMENTARIO])
            ->andFilterWhere(['like', 'ERS_ESTADO', $this->ERS_ID]);

        return $dataProvider;
    }
}
