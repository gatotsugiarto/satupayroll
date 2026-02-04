<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\BuktiPotongPph21;

/**
 * BuktiPotongPph21Search represents the model behind the search form of `common\modules\payroll\models\BuktiPotongPph21`.
 */
class BuktiPotongPph21Search extends BuktiPotongPph21
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'masa_pajak', 'tahun_pajak', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['npwp_perusahaan', 'nama_perusahaan', 'npwp_nik_pegawai', 'nama_pegawai', 'status_pegawai', 'kode_objek_pajak', 'status_ptkp', 'skema_pajak', 'created_at', 'updated_at'], 'safe'],
            [['penghasilan_bruto', 'biaya_jabatan', 'iuran_pensiun_jht', 'penghasilan_neto', 'pph21_terutang', 'pph21_dipotong_karyawan', 'pph21_ditanggung_perusahaan'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = BuktiPotongPph21::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'masa_pajak' => $this->masa_pajak,
            'tahun_pajak' => $this->tahun_pajak,
            'penghasilan_bruto' => $this->penghasilan_bruto,
            'biaya_jabatan' => $this->biaya_jabatan,
            'iuran_pensiun_jht' => $this->iuran_pensiun_jht,
            'penghasilan_neto' => $this->penghasilan_neto,
            'pph21_terutang' => $this->pph21_terutang,
            'pph21_dipotong_karyawan' => $this->pph21_dipotong_karyawan,
            'pph21_ditanggung_perusahaan' => $this->pph21_ditanggung_perusahaan,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'npwp_perusahaan', $this->npwp_perusahaan])
            ->andFilterWhere(['like', 'nama_perusahaan', $this->nama_perusahaan])
            ->andFilterWhere(['like', 'npwp_nik_pegawai', $this->npwp_nik_pegawai])
            ->andFilterWhere(['like', 'nama_pegawai', $this->nama_pegawai])
            ->andFilterWhere(['like', 'status_pegawai', $this->status_pegawai])
            ->andFilterWhere(['like', 'kode_objek_pajak', $this->kode_objek_pajak])
            ->andFilterWhere(['like', 'status_ptkp', $this->status_ptkp])
            ->andFilterWhere(['like', 'skema_pajak', $this->skema_pajak]);

        return $dataProvider;
    }
}
