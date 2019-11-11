<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefSubDivisi;

/**
 * RefSubDivisiSearch represents the model behind the search form about `app\models\RefSubDivisi`.
 */
class RefSubDivisiSearch extends RefSubDivisi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'divisi_id', 'sub_divisi_id', 'pengadaan'], 'integer'],
            [['nama_sub_divisi'], 'safe'],
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
        $query = RefSubDivisi::find();

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
            'sub_divisi_id' => $this->sub_divisi_id,
            'pengadaan' => $this->pengadaan,
        ]);

        $query->andFilterWhere(['like', 'nama_sub_divisi', $this->nama_sub_divisi]);

        return $dataProvider;
    }
}
