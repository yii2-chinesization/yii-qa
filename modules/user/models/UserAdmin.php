<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\User;

/**
 * UserAdmin represents the model behind the search form about `app\modules\user\models\User`.
 */
class UserAdmin extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'followers', 'following', 'photos', 'avatar_sid', 'status', 'last_visit_at', 'created_at', 'updated_at'], 'integer'],
            [['email', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'last_login_ip'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'followers' => $this->followers,
            'following' => $this->following,
            'photos' => $this->photos,
            'avatar_sid' => $this->avatar_sid,
            'status' => $this->status,
            'last_visit_at' => $this->last_visit_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip]);

        return $dataProvider;
    }
}
