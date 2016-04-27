<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DerivacionReclamoSugerencia;
use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;

/**
 * DerivacionReclamoSugerenciaSearch represents the model behind the search form about `frontend\models\DerivacionReclamoSugerencia`.
 */
class DerivacionReclamoSugerenciaSearch extends DerivacionReclamoSugerencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DRS_ID'], 'integer'],
            [['USU_RUT', 'DRS_CARGO', 'DRS_UNIDAD', 'DRS_FECHA_DERIVACION', 'DRS_FECHA_RESPUESTA', 'DRS_RESPUESTA','DRS_NOMBRE', 'EDR_ID', 'SRS_ID'], 'safe'],
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
        $query = DerivacionReclamoSugerencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('eDR');
        $query->joinWith('sRS');
        $query->andFilterWhere([
            'DRS_ID' => $this->DRS_ID,
            //'EDR_ID' => $this->EDR_ID,
            //'SRS_ID' => $this->SRS_ID,
            'DRS_FECHA_DERIVACION' => $this->DRS_FECHA_DERIVACION,
            'DRS_FECHA_RESPUESTA' => $this->DRS_FECHA_RESPUESTA,
        ]);

        $query->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'DRS_CARGO', $this->DRS_CARGO])
            ->andFilterWhere(['like', 'DRS_UNIDAD', $this->DRS_UNIDAD])
            ->andFilterWhere(['like', 'DRS_RESPUESTA', $this->DRS_RESPUESTA])
            ->andFilterWhere(['like', 'DRS_NOMBRE', $this->DRS_NOMBRE])
            ->andFilterWhere(['like', 'EDR_ESTADO', $this->EDR_ID])
            ->andFilterWhere(['like', 'REC_NUMERO', $this->SRS_ID]);

        return $dataProvider;
    }
}
