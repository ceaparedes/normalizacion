<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DerivacionSolicitudDocumento;

/**
 * DerivacionSolicitudDocumentoSearch represents the model behind the search form about `app\models\DerivacionSolicitudDocumento`.
 */
class DerivacionSolicitudDocumentoSearch extends DerivacionSolicitudDocumento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DSD_ID', 'EDS_ID'], 'integer'],
            [['SOL_ID', 'USU_RUT', 'DSD_CARGO', 'DSD_UNIDAD', 'DSD_FECHA_DERIVACION', 'DSD_FECHA_RESPUESTA'], 'safe'],
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
        $query = DerivacionSolicitudDocumento::find();

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
            'DSD_ID' => $this->DSD_ID,
            'EDS_ID' => $this->EDS_ID,
            'DSD_FECHA_DERIVACION' => $this->DSD_FECHA_DERIVACION,
            'DSD_FECHA_RESPUESTA' => $this->DSD_FECHA_RESPUESTA,
        ]);

        $query->andFilterWhere(['like', 'SOL_ID', $this->SOL_ID])
            ->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'DSD_CARGO', $this->DSD_CARGO])
            ->andFilterWhere(['like', 'DSD_UNIDAD', $this->DSD_UNIDAD]);

        return $dataProvider;
    }
}
