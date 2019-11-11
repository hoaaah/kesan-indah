<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefUnit;

/**
 * RefUnitSearch represents the model behind the search form about `app\models\RefUnit`.
 */
class RefUnitSearch extends RefUnit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kecamatan_id', 'kelurahan_id'], 'integer'],
            [['kd_unit_simda', 'nama_unit', 'alamat', 'kepala_unit', 'nip'], 'safe'],
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
        $query = RefUnit::find();

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
            'id' => $this->id,
            'kecamatan_id' => $this->kecamatan_id,
            'kelurahan_id' => $this->kelurahan_id,
        ]);

        $query->andFilterWhere(['like', 'kd_unit_simda', $this->kd_unit_simda])
            ->andFilterWhere(['like', 'nama_unit', $this->nama_unit])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'kepala_unit', $this->kepala_unit])
            ->andFilterWhere(['like', 'nip', $this->nip]);

        return $dataProvider;
    }
}
