<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kunjungan;

/**
 * KunjunganSearch represents the model behind the search form about `app\models\Kunjungan`.
 */
class KunjunganSearch extends Kunjungan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kunjungan_id', 'klinik_id'], 'integer'],
            [['mr', 'tanggal_periksa', 'jam_masuk', 'jam_selesai', 'status', 'created', 'user_input','pasien_nama'], 'safe'],
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
    public function search($params,$join_rm = false,$join_bayar = false,$status = '')
    {
        $query = Kunjungan::find();
        if(Yii::$app->user->identity->role!=10){
            if(Yii::$app->user->identity->role=='25')
                $query->where(['kunjungan.dokter_periksa'=>Yii::$app->user->identity->id]);
            else
                $query->where(['kunjungan.klinik_id'=>Yii::$app->user->identity->klinik_id]);
        }
            
                
        // add conditions that should always apply here
        if(!empty($status))
            $this->status = $status;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($join_rm) $query->joinWith('rekamMedis');
        if($join_bayar) $query->joinWith('bayar');
        $query->joinWith('mr0');
        $query->andFilterWhere([
            'tanggal_periksa' => $this->tanggal_periksa,
            'jam_masuk' => $this->jam_masuk,
            'jam_selesai' => $this->jam_selesai,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'pasien.mr', $this->mr])
            ->andFilterWhere(['like', 'pasien.nama', $this->pasien_nama])
            
            ->andFilterWhere(['like', 'user_input', $this->user_input]);

        if($status=='pemeriksaan'){
            $query->andFilterWhere(['or',['status'=>'antri'],['status'=>'diperiksa']]);
        } else {
            $query->andFilterWhere(['status'=>$this->status]);
        }
        if(!isset($params['sort']))
            $query->orderBy('jam_masuk ASC');
        
        return $dataProvider;
    }
}
