<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SolucionReclamoSugerencia;

/**
 * SolucionReclamoSugerenciaSearch represents the model behind the search form about `frontend\models\SolucionReclamoSugerencia`.
 */
class SolucionReclamoSugerenciaSearch extends SolucionReclamoSugerencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_RUT', 'REC_NUMERO', 'SRS_COMENTARIO', 'SRS_ANTECEDENTES', 'SRS_FECHA_RESPUESTA', 'SRS_FECHA_ENVIO', 'SRS_NOMBRE', 'SRS_ID', 'ESR_ID', 'SRS_VISTO_BUENO'], 'safe'],
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
        $query = SolucionReclamoSugerencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('eSR');
        $query->andFilterWhere([
            'SRS_ID' => $this->SRS_ID,
            'SRS_VISTO_BUENO' => $this->SRS_VISTO_BUENO,
            'SRS_FECHA_RESPUESTA' => $this->SRS_FECHA_RESPUESTA,
            'SRS_FECHA_ENVIO' => $this->SRS_FECHA_ENVIO,
        ]);

        $query->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'REC_NUMERO', $this->REC_NUMERO])
            ->andFilterWhere(['like', 'SRS_COMENTARIO', $this->SRS_COMENTARIO])
            ->andFilterWhere(['like', 'SRS_ANTECEDENTES', $this->SRS_ANTECEDENTES])
            ->andFilterWhere(['like', 'SRS_NOMBRE', $this->SRS_NOMBRE])
            ->andFilterWhere(['like', 'ESR_ESTADO', $this->ESR_ID]);

        return $dataProvider;
    }
}
