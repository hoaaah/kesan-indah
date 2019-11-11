<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BestPracticeFile;

/**
 * BestPracticeFileSearch represents the model behind the search form about `app\models\BestPracticeFile`.
 */
class BestPracticeFileSearch extends BestPracticeFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_unsur', 'kd_sub_unsur', 'level'], 'integer'],
            [['name', 'uraian', 'file', 'filename', 'ref'], 'safe'],
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
        $query = BestPracticeFile::find();

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
            'kd_unsur' => $this->kd_unsur,
            'kd_sub_unsur' => $this->kd_sub_unsur,
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'ref', $this->ref]);

        return $dataProvider;
    }
}
