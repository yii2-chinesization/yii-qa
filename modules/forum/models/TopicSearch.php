<?php

namespace app\modules\forum\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TopicSearch represents the model behind the search form about `app\modules\forum\models\Topic`.
 */
class TopicSearch extends Topic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fid', 'comment_count', 'created_at', 'updated_at'], 'integer'],
            [['subject', 'content'], 'safe'],
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
    public function search($params, $active = true)
    {
        $query = Topic::find();

        $active && $query->active();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fid' => $this->fid,
            'comment_count' => $this->comment_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content])
            ->orderBy([
                'tid' => SORT_DESC
            ]);

        return $dataProvider;
    }

    public function searchWithComments($params)
    {
        if (!isset($params[$this->formName()]['id'])) {
            throw new InvalidParamException('必须填写话题ID');
        }
        $dataProvider = $this->search($params, false);
        $dataProvider->query->orWhere(['fid' => $this->id]);
        return $dataProvider;
    }
}
