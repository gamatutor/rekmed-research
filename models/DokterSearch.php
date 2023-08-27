<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dokter;

/**
 * DokterSearch represents the model behind the search form about `app\models\Dokter`.
 */
class DokterSearch extends Dokter
{
    /**
     * @inheritdoc
     */
    public $klinik_id;
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['nama', 'no_telp', 'no_telp_2', 'spesialis', 'waktu_praktek', 'foto', 'alamat', 'tanggal_lahir', 'created'], 'safe'],
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
        $query = Dokter::find()->joinWith(['user'])->where(['status'=>10]);

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
            'user_id' => $this->user_id,
            'tanggal_lahir' => $this->tanggal_lahir,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'no_telp_2', $this->no_telp_2])
            ->andFilterWhere(['like', 'spesialis', $this->spesialis])
            ->andFilterWhere(['like', 'waktu_praktek', $this->waktu_praktek])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'user.klinik_id', $this->klinik_id]);

        return $dataProvider;
    }
}
