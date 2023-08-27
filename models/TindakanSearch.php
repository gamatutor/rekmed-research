<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tindakan;

/**
 * TindakanSearch represents the model behind the search form about `app\models\Tindakan`.
 */
class TindakanSearch extends Tindakan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tindakan_id', 'klinik_id', 'tarif_dokter', 'tarif_asisten'], 'integer'],
            [['nama_tindakan', 'created', 'modified'], 'safe'],
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
        $query = Tindakan::find();
        $query->where(['klinik_id'=>Yii::$app->user->identity->klinik_id]);
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
            'tindakan_id' => $this->tindakan_id,
            'klinik_id' => $this->klinik_id,
            'tarif_dokter' => $this->tarif_dokter,
            'tarif_asisten' => $this->tarif_asisten,
            'created' => $this->created,
            'modified' => $this->modified,
        ]);

        $query->andFilterWhere(['like', 'nama_tindakan', $this->nama_tindakan]);

        return $dataProvider;
    }
}
