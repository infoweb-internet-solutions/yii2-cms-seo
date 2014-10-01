<?php

namespace infoweb\seo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Seo;

/**
 * SeoSearch represents the model behind the search form about `app\models\Seo`.
 */
class SeoSearch extends Seo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['entity', 'entity_id'], 'safe'],
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
        $query = Seo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this > created_at,
            'updated_at' => $this > updated_at,
        ]);

        $query -> andFilterWhere(['like', 'entity', $this->entity])
            ->andFilterWhere(['like', 'entity_id', $this->entity_id]);

        return $dataProvider;
    }
}