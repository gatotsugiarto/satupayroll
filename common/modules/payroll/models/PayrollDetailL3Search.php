<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\PayrollDetailL3;

/**
 * PayrollDetailL3Search represents the model behind the search form of `common\modules\payroll\models\PayrollDetailL3`.
 */
class PayrollDetailL3Search extends PayrollDetailL3
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['period_code', 'payroll_mode', 'generate_mode', 'ter', 'created_at', 'updated_at'], 'safe'],
            [['basic', 'position_allow', 'ops_allow', 'fixed_income', 'overtime_allow', 'accodtn_allow', 'so_allow', 'ig_allow', 'doublepos_allow', 'misc_allow', 'var_income', 'actual_salary', 'jht_perusahaan', 'jp_perusahaan', 'jkm', 'jkk', 'bpjs_kes_perusahaan', 'employer_bpjs', 'thr', 'bonus', 'tunj_keseh', 'lembur', 'rev_absensi', 'tunj_pph21', 'cut_unpaid', 'cut_absensi', 'cut_alpha', 'other_income', 'bruto', 'employer_cost', 'bruto_tax', 'ter_rate', 'pph21_dec_net', 'bruto_tax_year', 'biaya_jabatan_year', 'jp_jht_kary_year', 'ptkp', 'pkp', 'neto_year', 'pph21_year', 'pph21_jan_nov', 'pph21_net_employer', 'pph21', 'jht_kary', 'jp_kary', 'bpjs_kes_kary', 'ded_misc', 'total_potongan', 'thp'], 'number'],
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
        $query = PayrollDetailL3::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'basic' => $this->basic,
            'position_allow' => $this->position_allow,
            'ops_allow' => $this->ops_allow,
            'fixed_income' => $this->fixed_income,
            'overtime_allow' => $this->overtime_allow,
            'accodtn_allow' => $this->accodtn_allow,
            'so_allow' => $this->so_allow,
            'ig_allow' => $this->ig_allow,
            'doublepos_allow' => $this->doublepos_allow,
            'misc_allow' => $this->misc_allow,
            'var_income' => $this->var_income,
            'actual_salary' => $this->actual_salary,
            'jht_perusahaan' => $this->jht_perusahaan,
            'jp_perusahaan' => $this->jp_perusahaan,
            'jkm' => $this->jkm,
            'jkk' => $this->jkk,
            'bpjs_kes_perusahaan' => $this->bpjs_kes_perusahaan,
            'employer_bpjs' => $this->employer_bpjs,
            'thr' => $this->thr,
            'bonus' => $this->bonus,
            'tunj_keseh' => $this->tunj_keseh,
            'lembur' => $this->lembur,
            'rev_absensi' => $this->rev_absensi,
            'tunj_pph21' => $this->tunj_pph21,
            'cut_unpaid' => $this->cut_unpaid,
            'cut_absensi' => $this->cut_absensi,
            'cut_alpha' => $this->cut_alpha,
            'other_income' => $this->other_income,
            'bruto' => $this->bruto,
            'employer_cost' => $this->employer_cost,
            'bruto_tax' => $this->bruto_tax,
            'ter_rate' => $this->ter_rate,
            'pph21_dec_net' => $this->pph21_dec_net,
            'bruto_tax_year' => $this->bruto_tax_year,
            'biaya_jabatan_year' => $this->biaya_jabatan_year,
            'jp_jht_kary_year' => $this->jp_jht_kary_year,
            'ptkp' => $this->ptkp,
            'pkp' => $this->pkp,
            'neto_year' => $this->neto_year,
            'pph21_year' => $this->pph21_year,
            'pph21_jan_nov' => $this->pph21_jan_nov,
            'pph21_net_employer' => $this->pph21_net_employer,
            'pph21' => $this->pph21,
            'jht_kary' => $this->jht_kary,
            'jp_kary' => $this->jp_kary,
            'bpjs_kes_kary' => $this->bpjs_kes_kary,
            'ded_misc' => $this->ded_misc,
            'total_potongan' => $this->total_potongan,
            'thp' => $this->thp,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'period_code', $this->period_code])
            ->andFilterWhere(['like', 'payroll_mode', $this->payroll_mode])
            ->andFilterWhere(['like', 'generate_mode', $this->generate_mode])
            ->andFilterWhere(['like', 'ter', $this->ter]);

        return $dataProvider;
    }
}
