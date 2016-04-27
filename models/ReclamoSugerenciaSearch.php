<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReclamoSugerencia;

/**
 * ReclamoSugerenciaSearch represents the model behind the search form about `app\models\ReclamoSugerencia`.
 */
class ReclamoSugerenciaSearch extends ReclamoSugerencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['REC_NUMERO', 'REC_FECHA', 'REC_REPARTICION', 'REC_HORA', 'USU_RUT','ERS_ID', 'TSR_ID', 'TRS_ID', 'REC_TELEFONO_USUARIO', 'REC_NOMBRE_USUARIO', 'REC_EMAIL_USUARIO', 'REC_MOTIVO', 'REC_VISTO_BUENO'], 'safe'],

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
        $query = ReclamoSugerencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ERS_ID' => $this->ERS_ID,
            'TSR_ID' => $this->TSR_ID,
            'TRS_ID' => $this->TRS_ID,
            'REC_FECHA' => $this->REC_FECHA,
            'REC_HORA' => $this->REC_HORA,
            'REC_TELEFONO_USUARIO' => $this->REC_TELEFONO_USUARIO,
        ]);

        $query->andFilterWhere(['like', 'REC_NUMERO', $this->REC_NUMERO])
            ->andFilterWhere(['like', 'REC_REPARTICION', $this->REC_REPARTICION])
            ->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'REC_NOMBRE_USUARIO', $this->REC_NOMBRE_USUARIO])
            ->andFilterWhere(['like', 'REC_EMAIL_USUARIO', $this->REC_EMAIL_USUARIO])
            ->andFilterWhere(['like', 'REC_MOTIVO', $this->REC_MOTIVO])
            ->andFilterWhere(['like', 'REC_VISTO_BUENO', $this->REC_VISTO_BUENO]);

        return $dataProvider;
    }
}
