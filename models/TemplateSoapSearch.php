<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TemplateSoap;

/**
 * TemplateSoapSearch represents the model behind the search form about `app\models\TemplateSoap`.
 */
class TemplateSoapSearch extends TemplateSoap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['nama_template', 'subject', 'object', 'assesment', 'plan', 'created'], 'safe'],
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
        $query = TemplateSoap::find();

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
        if(Yii::$app->user->identity->role == 10)
            $query->andFilterWhere([
                'id' => $this->id,
                'user' => $this->user,
                'created' => $this->created,
            ]);
        else
            $query->andFilterWhere([
                'id' => $this->id,
                'user' => Yii::$app->user->identity->id,
                'created' => $this->created,
            ]);

        $query->andFilterWhere(['like', 'nama_template', $this->nama_template])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'object', $this->object])
            ->andFilterWhere(['like', 'assesment', $this->assesment])
            ->andFilterWhere(['like', 'plan', $this->plan]);

        return $dataProvider;
    }
}
