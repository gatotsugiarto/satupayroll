<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\Payroll;

/**
 * PayrollSearch represents the model behind the search form of `common\modules\payroll\models\Payroll`.
 */
class PayrollSearch extends Payroll
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'month', 'year', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['period_code', 'reason', 'approved_at', 'created_at', 'updated_at'], 'safe'],
            [['gross', 'total_deduction', 'thp', 'thr_accrual'], 'number'],
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
        $query = Payroll::find();

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
            'month' => $this->month,
            'year' => $this->year,
            'gross' => $this->gross,
            'total_deduction' => $this->total_deduction,
            'thp' => $this->thp,
            'thr_accrual' => $this->thr_accrual,
            'approved_at' => $this->approved_at,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'period_code', $this->period_code])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
