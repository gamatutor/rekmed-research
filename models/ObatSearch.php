<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Obat;

/**
 * ObatSearch represents the model behind the search form about `app\models\Obat`.
 */
class ObatSearch extends Obat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obat_id', 'klinik_id', 'harga_beli', 'harga_jual', 'stok'], 'integer'],
            [['nama_merk', 'pabrikan', 'nama_generik', 'golongan', 'tanggal_beli', 'tanggal_kadaluarsa', 'created', 'modified'], 'safe'],
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
        $query = Obat::find();
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
            'obat_id' => $this->obat_id,
            'klinik_id' => $this->klinik_id,
            'tanggal_beli' => $this->tanggal_beli,
            'tanggal_kadaluarsa' => $this->tanggal_kadaluarsa,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'created' => $this->created,
            'modified' => $this->modified,
        ]);

        $query->andFilterWhere(['like', 'nama_merk', $this->nama_merk])
            ->andFilterWhere(['like', 'pabrikan', $this->pabrikan])
            ->andFilterWhere(['like', 'nama_generik', $this->nama_generik])
            ->andFilterWhere(['like', 'golongan', $this->golongan]);

        return $dataProvider;
    }
}
