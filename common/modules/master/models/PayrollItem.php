<?php

namespace common\modules\master\models;

use Yii;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\components\behaviors\TokenProtectedFormBehavior;
use common\components\behaviors\LoggableBehavior;

use common\modules\auth\models\User;

class PayrollItem extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TYPE_DATA = 'DATA';
    const TYPE_RATE = 'RATE';
    const TYPE_FORMULA = 'FORMULA';
    const TYPE_SUMMARY = 'SUMMARY';
    const SIGN_PLUS = 'PLUS';
    const SIGN_MINUS = 'MINUS';
    const SIGN_NONE = 'NONE';
    const SALARY_TYPE_RECURRING = 'RECURRING';
    const SALARY_TYPE_ONETIME = 'ONETIME';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_item';
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
                'sessionKey' => 'payrollitem_token',
            ],
            
            // log activity otomatis
            [
                'class' => LoggableBehavior::class,
                'modelName' => 'PayrollItem', // opsional, default pakai nama tabel
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'category_id', 'display_order', 'percent', 'cap', 'item_code', 'base_multiplier'], 'default', 'value' => null],
            [['type'], 'default', 'value' => 'DATA'],
            [['sign'], 'default', 'value' => 'NONE'],
            [['affects_gross_tax', 'is_reprocessable'], 'default', 'value' => 0],
            [['monthly_exec', 'taxable','status_id'], 'default', 'value' => 1],
            [['salary_type'], 'default', 'value' => 'RECURRING'],
            [['category_id', 'affects_gross_tax', 'taxable', 'display_order', 'monthly_exec', 'created_by', 'updated_by'], 'integer'],
            [['type', 'sign', 'salary_type'], 'string'],
            [['percent', 'cap'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 120],
            ['type', 'in', 'range' => array_keys(self::optsType())],
            ['sign', 'in', 'range' => array_keys(self::optsSign())],
            ['salary_type', 'in', 'range' => array_keys(self::optsSalaryType())],
            [['code'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayrollCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Main Code',
            'name' => 'Payroll Component',
            'category_id' => 'Payroll Category',
            'type' => 'Type',
            'sign' => 'Sign',
            'affects_gross_tax' => 'Affects Gross Tax',
            'taxable' => 'Taxable',
            'display_order' => 'Display Order',
            'percent' => 'Percent',
            'cap' => 'Wage Ceiling',
            'salary_type' => 'Salary Type',
            'is_reprocessable' => 'Reprocessable',
            'item_code' => 'Var Component Code',
            'monthly_exec' => 'Month Execute',
            'base_multiplier' => 'Base Multiplier',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PayrollCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[EmployeeComponentValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeComponentValues()
    {
        return $this->hasMany(EmployeeComponentValue::class, ['payroll_item_id' => 'id']);
    }

    public function getStatus()
    {
        return $this->hasOne(StatusActive::class, ['id' => 'status_id']);
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


    /**
     * column type ENUM value labels
     * @return string[]
     */
    public static function optsType()
    {
        return [
            self::TYPE_DATA => 'DATA',
            self::TYPE_RATE => 'RATE',
            self::TYPE_FORMULA => 'FORMULA',
            self::TYPE_SUMMARY => 'SUMMARY',
        ];
    }

    /**
     * column sign ENUM value labels
     * @return string[]
     */
    public static function optsSign()
    {
        return [
            self::SIGN_PLUS => 'PLUS',
            self::SIGN_MINUS => 'MINUS',
            self::SIGN_NONE => 'NONE',
        ];
    }

    /**
     * column salary_type ENUM value labels
     * @return string[]
     */
    public static function optsSalaryType()
    {
        return [
            self::SALARY_TYPE_RECURRING => 'RECURRING',
            self::SALARY_TYPE_ONETIME => 'ONETIME',
        ];
    }

    /**
     * @return string
     */
    public function displayType()
    {
        return self::optsType()[$this->type];
    }

    /**
     * @return bool
     */
    public function isTypeData()
    {
        return $this->type === self::TYPE_DATA;
    }

    public function setTypeToData()
    {
        $this->type = self::TYPE_DATA;
    }

    /**
     * @return bool
     */
    public function isTypeRate()
    {
        return $this->type === self::TYPE_RATE;
    }

    public function setTypeToRate()
    {
        $this->type = self::TYPE_RATE;
    }

    /**
     * @return bool
     */
    public function isTypeFormula()
    {
        return $this->type === self::TYPE_FORMULA;
    }

    public function setTypeToFormula()
    {
        $this->type = self::TYPE_FORMULA;
    }

    /**
     * @return bool
     */
    public function isTypeSummary()
    {
        return $this->type === self::TYPE_SUMMARY;
    }

    public function setTypeToSummary()
    {
        $this->type = self::TYPE_SUMMARY;
    }

    /**
     * @return string
     */
    public function displaySign()
    {
        return self::optsSign()[$this->sign];
    }

    /**
     * @return bool
     */
    public function isSignPlus()
    {
        return $this->sign === self::SIGN_PLUS;
    }

    public function setSignToPlus()
    {
        $this->sign = self::SIGN_PLUS;
    }

    /**
     * @return bool
     */
    public function isSignMinus()
    {
        return $this->sign === self::SIGN_MINUS;
    }

    public function setSignToMinus()
    {
        $this->sign = self::SIGN_MINUS;
    }

    /**
     * @return bool
     */
    public function isSignNone()
    {
        return $this->sign === self::SIGN_NONE;
    }

    public function setSignToNone()
    {
        $this->sign = self::SIGN_NONE;
    }

    /**
     * @return string
     */
    public function displaySalaryType()
    {
        return self::optsSalaryType()[$this->salary_type];
    }

    /**
     * @return bool
     */
    public function isSalaryTypeRecurring()
    {
        return $this->salary_type === self::SALARY_TYPE_RECURRING;
    }

    public function setSalaryTypeToRecurring()
    {
        $this->salary_type = self::SALARY_TYPE_RECURRING;
    }

    /**
     * @return bool
     */
    public function isSalaryTypeOnetime()
    {
        return $this->salary_type === self::SALARY_TYPE_ONETIME;
    }

    public function setSalaryTypeToOnetime()
    {
        $this->salary_type = self::SALARY_TYPE_ONETIME;
    }

    public static function dropdown()
    {
        static $dropdown;
        if ($dropdown === null) {
            
            $models = static::find()->where(['type' => 'DATA'])->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->name.' ['.$model->code.']';
            }
        }
            
        return $dropdown;
    }

    public static function dropdownall()
    {
        static $dropdown;
        if ($dropdown === null) {
            
            $models = static::find()->where(['status_id' => 1])->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->name.' ['.$model->code.']';
            }
        }
            
        return $dropdown;
    }
}
