<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BorradorDocumento;

/**
 * BorradorDocumentoSearch represents the model behind the search form about `app\models\BorradorDocumento`.
 */
class BorradorDocumentoSearch extends BorradorDocumento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BDO_ID', 'EBD_ID'], 'integer'],
            [['SOL_ID', 'BDO_FECHA_ENVIO', 'BDO_FECHA_RESPUESTA'], 'safe'],
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
        $query = BorradorDocumento::find();

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
            'BDO_ID' => $this->BDO_ID,
            'EBD_ID' => $this->EBD_ID,
            'BDO_FECHA_ENVIO' => $this->BDO_FECHA_ENVIO,
            'BDO_FECHA_RESPUESTA' => $this->BDO_FECHA_RESPUESTA,
        ]);

        $query->andFilterWhere(['like', 'SOL_ID', $this->SOL_ID]);

        return $dataProvider;
    }
}
