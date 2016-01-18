<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialVersionDocumento;

/**
 * HistorialVersionDocumentoSearch represents the model behind the search form about `app\models\HistorialVersionDocumento`.
 */
class HistorialVersionDocumentoSearch extends HistorialVersionDocumento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HVD_ID', 'DOC_CODIGO', 'VER_ID'], 'integer'],
            [['USU_RUT', 'HVD_FECHA_HORA', 'HVD_COMENTARIO', 'HVD_VISTO_BUENO'], 'safe'],
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
        $query = HistorialVersionDocumento::find();

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
            'HVD_ID' => $this->HVD_ID,
            'DOC_CODIGO' => $this->DOC_CODIGO,
            'VER_ID' => $this->VER_ID,
            'HVD_FECHA_HORA' => $this->HVD_FECHA_HORA,
        ]);

        $query->andFilterWhere(['like', 'USU_RUT', $this->USU_RUT])
            ->andFilterWhere(['like', 'HVD_COMENTARIO', $this->HVD_COMENTARIO])
            ->andFilterWhere(['like', 'HVD_VISTO_BUENO', $this->HVD_VISTO_BUENO]);

        return $dataProvider;
    }
}
