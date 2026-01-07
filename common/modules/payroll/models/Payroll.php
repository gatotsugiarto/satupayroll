<?php

namespace common\modules\payroll\models;

use Yii;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use common\components\behaviors\TokenProtectedFormBehavior;
use common\components\behaviors\LoggableBehavior;

use common\components\payroll\Calculate;

/**
 * This is the model class for table "payroll".
 *
 * @property int $id
 * @property int $employee_id
 * @property int|null $month
 * @property int|null $year
 * @property string $period_code
 * @property float|null $gross
 * @property float|null $total_deduction
 * @property float|null $thp
 * @property float|null $thr_accrual
 * @property string|null $reason
 * @property string|null $approved_at
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property Employee $employee
 */
class Payroll extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason', 'approved_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status_id'], 'default', 'value' => 1],
            [['thr_accrual'], 'default', 'value' => 0.00],
            [['employee_id', 'period_code'], 'required'],
            [['employee_id', 'month', 'year', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['gross', 'total_deduction', 'thp', 'thr_accrual'], 'number'],
            [['approved_at', 'created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['reason'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'month' => 'Month',
            'year' => 'Year',
            'period_code' => 'Period Code',
            'gross' => 'Gross',
            'total_deduction' => 'Total Deduction',
            'thp' => 'Thp',
            'thr_accrual' => 'Thr Accrual',
            'reason' => 'Reason',
            'approved_at' => 'Approved At',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public function PayrollGenerate($generate_mode, $employee_id=0)
    {
        
        $month = $this->month;
        $year = $this->year;
        $period_code = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $status_id = 1;
        $user_id = Yii::$app->user->id;

        if($generate_mode == 'Batch'){
            Calculate::PayrollGenerateBatch($period_code, $status_id, $user_id);
        }else{
            Calculate::PayrollGenerateSingle($employee_id, $period_code, $status_id, $user_id);
        }
    }

}
