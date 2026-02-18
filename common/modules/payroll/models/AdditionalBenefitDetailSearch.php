<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\AdditionalBenefitDetail;

/**
 * AdditionalBenefitDetailSearch represents the model behind the search form of `common\modules\payroll\models\AdditionalBenefitDetail`.
 */
class AdditionalBenefitDetailSearch extends AdditionalBenefitDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'display_order', 'profile_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['period_code', 'item_code', 'item_name', 'category_code', 'description', 'source', 'trace', 'generate_mode', 'slip_display', 'slip_position', 'created_at', 'updated_at'], 'safe'],
            [['amount'], 'number'],
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
        $query = AdditionalBenefitDetail::find();

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
            'amount' => $this->amount,
            'display_order' => $this->display_order,
            'profile_id' => $this->profile_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'period_code', $this->period_code])
            ->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'category_code', $this->category_code])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'trace', $this->trace])
            ->andFilterWhere(['like', 'generate_mode', $this->generate_mode])
            ->andFilterWhere(['like', 'slip_display', $this->slip_display])
            ->andFilterWhere(['like', 'slip_position', $this->slip_position]);

        return $dataProvider;
    }
}
