<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefDivisi;

/**
 * RefDivisiSearch represents the model behind the search form about `app\models\RefDivisi`.
 */
class RefDivisiSearch extends RefDivisi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'divisi_id'], 'integer'],
            [['nama_divisi'], 'safe'],
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
        $query = RefDivisi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'unit_id' => $this->unit_id,
            'divisi_id' => $this->divisi_id,
        ]);

        $query->andFilterWhere(['like', 'nama_divisi', $this->nama_divisi]);

        return $dataProvider;
    }
}
