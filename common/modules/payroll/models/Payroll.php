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
use common\components\payroll\ReportSummary;
use common\components\payroll\OtherDoc;

use common\modules\master\models\Employee;
use common\modules\master\models\Month;
use common\modules\master\models\StatusPayroll;
use common\modules\auth\models\User;

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

    public function behaviors()
    {
        if ($this instanceof UserSearch) {
            return [];
        }

        return [
            // created_at & updated_at => NOW()
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],

            // created_by & updated_by => user login
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            
            // token protection untuk form
            'tokenProtection' => [
                'class' => TokenProtectedFormBehavior::class,
                'tokenAttribute' => 'form_token',
                'sessionKey' => 'payroll_token',
            ],
            
            // log activity otomatis
            [
                'class' => LoggableBehavior::class,
                'modelName' => 'Payroll', // opsional, default pakai nama tabel
            ],
        ];
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
            // [['employee_id', 'period_code'], 'required'],
            [['year', 'month'], 'required'],
            [['employee_id', 'month', 'year', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['gross', 'total_deduction', 'thp', 'thr_accrual'], 'number'],
            [['approved_at', 'created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['reason'], 'string', 'max' => 255],
            ['status_id', 'validateStatusCreate', 'on' => 'create'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    public function validateStatusCreate($attribute, $params)
    {
        if ($this->$attribute == 1) {
            $this->addError('month', 'This payroll is awaiting Finance approval and cannot be processed while its status is Draft.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee',
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

    public function getRmonth()
    {
        return $this->hasOne(Month::class, ['id' => 'month']);
    }

    public function getStatus()
    {
        return $this->hasOne(StatusPayroll::class, ['id' => 'status_id']);
    }

    // Relasi ke user created
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    // Relasi ke user updated
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function PayrollGenerate($generate_mode, $employee_id=0)
    {
        
        $month = $this->month;
        $year = $this->year;
        $period_code = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $status_id = 1;
        $user_id = Yii::$app->user->id;

        if($generate_mode == 'Batch'){
            Calculate::PayrollGenerateBatch($year, $month, $period_code, $status_id, $user_id);
            ReportSummary::BatchL3($year, $month, $period_code, $status_id, $user_id);
            Calculate::PayrollHeaderBatch($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::BuktiPotong($year, $month, $period_code, $status_id, $user_id);
            ReportSummary::BatchL1($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::Formulir1721($year, $month, $period_code, $status_id, $user_id);

        }else{
            Calculate::PayrollGenerateSingle($employee_id, $year, $month, $period_code, $status_id, $user_id);
            ReportSummary::SingleL1($employee_id, $year, $month, $period_code, $status_id, $user_id);
        }
    }

}
