<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\AdditionalBenefit;

/**
 * AdditionalBenefitSearch represents the model behind the search form of `common\modules\payroll\models\AdditionalBenefit`.
 */
class AdditionalBenefitSearch extends AdditionalBenefit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'month', 'year', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['employee_id', 'period_code', 'description', 'created_at', 'updated_at'], 'safe'],
            [['total'], 'number'],
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
        $query = AdditionalBenefit::find();
        $query->joinWith(['employee']);

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
            // 'employee_id' => $this->employee_id,
            'month' => $this->month,
            'year' => $this->year,
            'total' => $this->total,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'period_code', $this->period_code])
            ->andFilterWhere(['like', 'employee.fullname', $this->employee_id])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
