<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Klinik;

/**
 * KlinikSearch represents the model behind the search form about `app\models\Klinik`.
 */
class KlinikSearch extends Klinik
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['klinik_id'], 'integer'],
            [['klinik_nama', 'alamat', 'nomor_telp_1', 'nomor_telp_2', 'kepala_klinik'], 'safe'],
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
        $query = Klinik::find();

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
            'klinik_id' => $this->klinik_id,
        ]);

        $query->andFilterWhere(['like', 'klinik_nama', $this->klinik_nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'nomor_telp_1', $this->nomor_telp_1])
            ->andFilterWhere(['like', 'nomor_telp_2', $this->nomor_telp_2])
            ->andFilterWhere(['like', 'kepala_klinik', $this->kepala_klinik]);

        return $dataProvider;
    }
}
