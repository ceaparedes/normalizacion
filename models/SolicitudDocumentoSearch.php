<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SolicitudDocumento;

/**
 * SolicitudDocumentoSearch represents the model behind the search form about `app\models\SolicitudDocumento`.
 */
class SolicitudDocumentoSearch extends SolicitudDocumento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOL_ID', 'USU_RUT', 'SOL_FECHA', 'SOL_UNIDAD', 'SOL_FUNDAMENTO'], 'safe'],
            [['DOC_CODIGO', 'VER_ID', 'PDA_ID', 'ESO_ID', 'ODO_ID', 'TAS_ID', 'SIS_ID', 'SRS_ID'], 'integer'],
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
        $query = SolicitudDocumento::find();

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
            'DOC_CODIGO' => $this->DOC_CODIGO,
            'VER_ID' => $this->VER_ID,
            'PDA_ID' => $this->PDA_ID,
            'ESO_ID' => $this->ESO_ID,
            'ODO_ID' => $this->ODO_ID,
            'TAS_ID' => $this->TAS_ID,
            'SIS_ID' => $this->SIS_ID,
            'SRS_ID' => $this->SRS_ID,
            'SOL_FECHA' => $this->SOL_FECHA,
        ]);

        $query->andFilterWhere(['like', 'SOL_ID', $this->SOL_ID])
            ->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'SOL_UNIDAD', $this->SOL_UNIDAD])
            ->andFilterWhere(['like', 'SOL_FUNDAMENTO', $this->SOL_FUNDAMENTO]);

        return $dataProvider;
    }
}
