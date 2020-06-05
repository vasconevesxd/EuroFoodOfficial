<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ExperienceType;

/**
 * ExperienceTypeSearch represents the model behind the search form of `common\models\ExperienceType`.
 */
class ExperienceTypeSearch extends ExperienceType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'id_meal', 'id_countries', 'id_chef', 'status'], 'integer'],
            [['title', 'images', 'maps', 'description', 'start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ExperienceType::find();

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
            'price' => $this->price,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'id_meal' => $this->id_meal,
            'id_countries' => $this->id_countries,
            'id_chef' => $this->id_chef,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'maps', $this->maps])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
