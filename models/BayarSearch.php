<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bayar;

/**
 * BayarSearch represents the model behind the search form about `app\models\Bayar`.
 */
class BayarSearch extends Bayar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_invoice', 'mr', 'nama_pasien', 'alamat', 'tanggal_bayar', 'created'], 'safe'],
            [['subtotal', 'diskon', 'total', 'kembali', 'bayar'], 'integer'],
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
        $query = Bayar::find();
        $query->joinWith('kunjungan');
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
            'tanggal_bayar' => $this->tanggal_bayar,
            'subtotal' => $this->subtotal,
            'diskon' => $this->diskon,
            'total' => $this->total,
            'kembali' => $this->kembali,
            'bayar' => $this->bayar,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'no_invoice', $this->no_invoice])
            ->andFilterWhere(['like', 'mr', $this->mr])
            ->andFilterWhere(['like', 'nama_pasien', $this->nama_pasien])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}
