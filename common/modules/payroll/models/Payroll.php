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

class Payroll extends \yii\db\ActiveRecord
{

    public $arr_employee_id;

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
            [['gross', 'pph21', 'total_deduction', 'thp', 'thr_accrual'], 'number'],
            [['arr_employee_id', 'approved_at', 'created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['reason'], 'string', 'max' => 255],
            ['month', 'validateStatusCreate', 'on' => 'create'],
            [['arr_employee_id'], 'required', 'on' => 'single'],
            ['month', 'validateStatusCreateSingle', 'on' => 'single'],
            ['month', 'validateApprove', 'on' => 'approve'],
            ['month', 'validateCancel', 'on' => 'cancel'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    public function validateStatusCreate($attribute, $params)
    {
        $exists = PayrollDetail::find()->where(['status_id' => 1])->limit(1)->exists();
        if ($exists) {
            $this->addError('month', 'This payroll is awaiting Finance approval and cannot be processed while its status is Draft.');
        }
    }

    public function validateStatusCreateSingle($attribute, $params)
    {
        $period_code = $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $exists = PayrollDetail::find()->where(['status_id' => 1, 'period_code' => $period_code])->limit(1)->exists();
        if(!$exists){
            $this->addError('month', 'Revisions can only be performed on payrolls with a Draft status.');
        }
    }

    public function validateApprove($attribute, $params)
    {
        $period_code = $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $exists = PayrollDetail::find()->where(['period_code' => $period_code])->limit(1)->exists();
        if(!$exists){
            $this->addError('month', 'Approval failed. No payroll record was found for the selected period.');
        }

        $period_code = $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $exists = PayrollDetail::find()->where(['status_id' => 2, 'period_code' => $period_code])->limit(1)->exists();
        if($exists){
            $this->addError('month', 'Approval failed. The payroll for the selected period has already been approved.');
        }
        
    }

    public function validateCancel($attribute, $params)
    {
        $period_code = $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $exists = PayrollDetail::find()->where(['period_code' => $period_code])->limit(1)->exists();
        if(!$exists){
            $this->addError('month', 'Cancel failed. No payroll record was found for the selected period.');
        }

        $period_code = $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $exists = PayrollDetail::find()->where(['status_id' => 2, 'period_code' => $period_code])->limit(1)->exists();
        if($exists){
            $this->addError('month', 'Cancellation can only be performed on payrolls with a Draft status.');
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
            'pph21' => 'PPh21',
            // 'total_deduction' => 'Total Deduction',
            'thp' => 'Thp',
            'thr_accrual' => 'THR Accrual',
            'reason' => 'Reason',
            'arr_employee_id' => 'Employee(s)',
            'approved_at' => 'Approved At',
            'status_id' => 'Status',
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

    public function PayrollGenerate($generate_mode, $employee_id=array())
    {
        
        $month = $this->month;
        $year = $this->year;
        $period_code = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $status_id = 1;
        $user_id = Yii::$app->user->id;

        if($employee_id){
            $generate_mode = 'Single';
            Calculate::PayrollCancel($year, $month, $period_code, $status_id, $user_id, $employee_id);
            Calculate::PayrollGenerateSingle($employee_id, $year, $month, $period_code, $status_id, $user_id);
            ReportSummary::BatchL3($year, $month, $period_code, $status_id, $user_id, $employee_id);
            Calculate::PayrollHeader($year, $month, $period_code, $status_id, $user_id, $employee_id);
            Calculate::AdditionalBenefitHeader($year, $month, $period_code, $status_id, $user_id, $employee_id);
            OtherDoc::BuktiPotong($year, $month, $period_code, $status_id, $user_id, $employee_id);
            ReportSummary::BatchL1($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::Formulir1721($year, $month, $period_code, $status_id, $user_id, $employee_id);
            OtherDoc::BPJSFiling($year, $month, $period_code, $status_id, $user_id, $employee_id);
        }else{
            $generate_mode = 'Batch';
            Calculate::PayrollCancel($year, $month, $period_code, $status_id, $user_id);
            Calculate::PayrollGenerateBatch($year, $month, $period_code, $status_id, $user_id);
            ReportSummary::BatchL3($year, $month, $period_code, $status_id, $user_id);
            Calculate::PayrollHeader($year, $month, $period_code, $status_id, $user_id);
            Calculate::AdditionalBenefitHeader($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::BuktiPotong($year, $month, $period_code, $status_id, $user_id);
            ReportSummary::BatchL1($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::Formulir1721($year, $month, $period_code, $status_id, $user_id);
            OtherDoc::BPJSFiling($year, $month, $period_code, $status_id, $user_id);
        }
    }

    public function PayrollApprove($generate_mode, $employee_id=0)
    {
        
        $month = $this->month;
        $year = $this->year;
        $period_code = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $status_id = 2;
        $user_id = Yii::$app->user->id;

        if($generate_mode == 'Batch'){
            Calculate::PayrollApproveBatch($year, $month, $period_code, $status_id, $user_id);
        }else{
            Calculate::PayrollApproveSingle($employee_id, $year, $month, $period_code, $status_id, $user_id);
        }

        /*
        PENTING, CLOSE SALARY
        */
        Calculate::PayrollCloseSalary($year, $month, $period_code);
    }

    public function PayrollCancel($generate_mode, $employee_id=0)
    {
        
        $month = $this->month;
        $year = $this->year;
        $period_code = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        $status_id = 2;
        $user_id = Yii::$app->user->id;

        if($generate_mode == 'Batch'){
            Calculate::PayrollCancel($year, $month, $period_code, $status_id, $user_id);
        }
    }

}
