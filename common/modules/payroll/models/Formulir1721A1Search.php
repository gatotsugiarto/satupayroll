<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\Formulir1721A1;

/**
 * Formulir1721A1Search represents the model behind the search form of `common\modules\payroll\models\Formulir1721A1`.
 */
class Formulir1721A1Search extends Formulir1721A1
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'tahun_pajak', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['npwp_perusahaan', 'nama_perusahaan', 'alamat_perusahaan', 'nama_pegawai', 'npwp_nik_pegawai', 'status_ptkp', 'alamat_pegawai', 'nama_pejabat', 'sign_name', 'sign_image', 'created_at', 'updated_at'], 'safe'],
            [['penghasilan_bruto', 'biaya_jabatan', 'iuran_pensiun_jht', 'penghasilan_neto', 'pkp', 'pph21_terutang', 'pph21_dipotong_perusahaan'], 'number'],
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
        $query = Formulir1721A1::find();

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
            'employee_id' => $this->employee_id,
            'tahun_pajak' => $this->tahun_pajak,
            'penghasilan_bruto' => $this->penghasilan_bruto,
            'biaya_jabatan' => $this->biaya_jabatan,
            'iuran_pensiun_jht' => $this->iuran_pensiun_jht,
            'penghasilan_neto' => $this->penghasilan_neto,
            'pkp' => $this->pkp,
            'pph21_terutang' => $this->pph21_terutang,
            'pph21_dipotong_perusahaan' => $this->pph21_dipotong_perusahaan,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'npwp_perusahaan', $this->npwp_perusahaan])
            ->andFilterWhere(['like', 'nama_perusahaan', $this->nama_perusahaan])
            ->andFilterWhere(['like', 'alamat_perusahaan', $this->alamat_perusahaan])
            ->andFilterWhere(['like', 'nama_pegawai', $this->nama_pegawai])
            ->andFilterWhere(['like', 'npwp_nik_pegawai', $this->npwp_nik_pegawai])
            ->andFilterWhere(['like', 'status_ptkp', $this->status_ptkp])
            ->andFilterWhere(['like', 'alamat_pegawai', $this->alamat_pegawai])
            ->andFilterWhere(['like', 'nama_pejabat', $this->nama_pejabat])
            ->andFilterWhere(['like', 'sign_name', $this->sign_name])
            ->andFilterWhere(['like', 'sign_image', $this->sign_image]);

        return $dataProvider;
    }
}
