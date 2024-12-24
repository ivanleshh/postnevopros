<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostMainSearch represents the model behind the search form of `app\models\Post`.
 */
class PostMainSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'theme_id', 'user_id', 'status_id'], 'integer'],
            [['title', 'text', 'created_at', 'preview', 'photo', 'updated_at', 'cancel_reason', 'other_theme'], 'safe'],
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
        $query = Post::find()->where(['status_id' => Status::getStatusId('Одобрен')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
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
            'theme_id' => $this->theme_id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'other_theme', $this->other_theme]);

        return $dataProvider;
    }
}
