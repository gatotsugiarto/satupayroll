<?php

namespace common\modules\payroll\models;

use Yii;

/**
 * This is the model class for table "payroll_detail".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $period_code
 * @property string $item_code
 * @property string $item_name
 * @property string $category_code
 * @property float $amount
 * @property string|null $source
 * @property string|null $trace
 * @property int|null $display_order
 * @property string|null $generate_mode
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property Employee $employee
 */
class PayrollDetail extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const SOURCE_DATA = 'DATA';
    const SOURCE_RATE = 'RATE';
    const SOURCE_FORMULA = 'FORMULA';
    const SOURCE_SUMMARY = 'SUMMARY';
    const SOURCE_META = 'META';
    const GENERATE_MODE_BATCH = 'Batch';
    const GENERATE_MODE_SINGLE = 'Single';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trace', 'generate_mode', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['amount'], 'default', 'value' => 0.00],
            [['source'], 'default', 'value' => 'DATA'],
            [['display_order'], 'default', 'value' => 0],
            [['status_id'], 'default', 'value' => 1],
            [['employee_id', 'period_code', 'item_code', 'item_name', 'category_code'], 'required'],
            [['employee_id', 'display_order', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['source', 'generate_mode'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['item_code', 'category_code'], 'string', 'max' => 40],
            [['item_name'], 'string', 'max' => 120],
            [['trace'], 'string', 'max' => 255],
            ['source', 'in', 'range' => array_keys(self::optsSource())],
            ['generate_mode', 'in', 'range' => array_keys(self::optsGenerateMode())],
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
            'period_code' => 'Period Code',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'category_code' => 'Category Code',
            'amount' => 'Amount',
            'source' => 'Source',
            'trace' => 'Trace',
            'display_order' => 'Display Order',
            'generate_mode' => 'Generate Mode',
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


    /**
     * column source ENUM value labels
     * @return string[]
     */
    public static function optsSource()
    {
        return [
            self::SOURCE_DATA => 'DATA',
            self::SOURCE_RATE => 'RATE',
            self::SOURCE_FORMULA => 'FORMULA',
            self::SOURCE_SUMMARY => 'SUMMARY',
            self::SOURCE_META => 'META',
        ];
    }

    /**
     * column generate_mode ENUM value labels
     * @return string[]
     */
    public static function optsGenerateMode()
    {
        return [
            self::GENERATE_MODE_BATCH => 'Batch',
            self::GENERATE_MODE_SINGLE => 'Single',
        ];
    }

    /**
     * @return string
     */
    public function displaySource()
    {
        return self::optsSource()[$this->source];
    }

    /**
     * @return bool
     */
    public function isSourceData()
    {
        return $this->source === self::SOURCE_DATA;
    }

    public function setSourceToData()
    {
        $this->source = self::SOURCE_DATA;
    }

    /**
     * @return bool
     */
    public function isSourceRate()
    {
        return $this->source === self::SOURCE_RATE;
    }

    public function setSourceToRate()
    {
        $this->source = self::SOURCE_RATE;
    }

    /**
     * @return bool
     */
    public function isSourceFormula()
    {
        return $this->source === self::SOURCE_FORMULA;
    }

    public function setSourceToFormula()
    {
        $this->source = self::SOURCE_FORMULA;
    }

    /**
     * @return bool
     */
    public function isSourceSummary()
    {
        return $this->source === self::SOURCE_SUMMARY;
    }

    public function setSourceToSummary()
    {
        $this->source = self::SOURCE_SUMMARY;
    }

    /**
     * @return bool
     */
    public function isSourceMeta()
    {
        return $this->source === self::SOURCE_META;
    }

    public function setSourceToMeta()
    {
        $this->source = self::SOURCE_META;
    }

    /**
     * @return string
     */
    public function displayGenerateMode()
    {
        return self::optsGenerateMode()[$this->generate_mode];
    }

    /**
     * @return bool
     */
    public function isGenerateModeBatch()
    {
        return $this->generate_mode === self::GENERATE_MODE_BATCH;
    }

    public function setGenerateModeToBatch()
    {
        $this->generate_mode = self::GENERATE_MODE_BATCH;
    }

    /**
     * @return bool
     */
    public function isGenerateModeSingle()
    {
        return $this->generate_mode === self::GENERATE_MODE_SINGLE;
    }

    public function setGenerateModeToSingle()
    {
        $this->generate_mode = self::GENERATE_MODE_SINGLE;
    }
}
