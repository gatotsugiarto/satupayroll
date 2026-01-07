<?php

namespace common\modules\payroll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\payroll\models\EmployeeJoinResign;

/**
 * EmployeeJoinResignSearch represents the model behind the search form of `common\modules\payroll\models\EmployeeJoinResign`.
 */
class EmployeeJoinResignSearch extends EmployeeJoinResign
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'identity_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['e_number', 'fullname', 'division', 'jabatan', 'upload_date', 'referral_code', 'created_at', 'updated_at'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EmployeeJoinResign::find();

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
            'id' => $this->id,
            'identity_id' => $this->identity_id,
            'upload_date' => $this->upload_date,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'e_number', $this->e_number])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'referral_code', $this->referral_code]);

        return $dataProvider;
    }
}
