<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PasienNextVisit;

/**
 * PasienNextVisitSearch represents the model behind the search form about `app\models\PasienNextVisit`.
 */
class PasienNextVisitSearch extends PasienNextVisit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pasien_schedule_id'], 'integer'],
            [['mr', 'agenda', 'desc', 'next_visit', 'created_at'], 'safe'],
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
        $query = PasienNextVisit::find();

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
            'pasien_schedule_id' => $this->pasien_schedule_id,
            'next_visit' => $this->next_visit,
            'created_at' => $this->created_at,
            'created_by' => Yii::$app->user->identity->id
        ]);

        $query->andFilterWhere(['like', 'mr', $this->mr])
            ->andFilterWhere(['like', 'agenda', $this->agenda])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
