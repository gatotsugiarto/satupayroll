<?php

namespace common\modules\payroll\models;

use Yii;

/**
 * This is the model class for table "payroll_detail_l1".
 *
 * @property int $id
 * @property int $report_item_id
 * @property string $period_code
 * @property string $label
 * @property int $amount
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property ReportItem $reportItem
 */
class PayrollDetailL1 extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_detail_l1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['amount'], 'default', 'value' => 0],
            [['status_id'], 'default', 'value' => 1],
            [['report_item_id', 'period_code', 'label'], 'required'],
            [['report_item_id', 'amount', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['label'], 'string', 'max' => 50],
            [['report_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportItem::class, 'targetAttribute' => ['report_item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_item_id' => 'Report Item ID',
            'period_code' => 'Period Code',
            'label' => 'Label',
            'amount' => 'Amount',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[ReportItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportItem()
    {
        return $this->hasOne(ReportItem::class, ['id' => 'report_item_id']);
    }

}
