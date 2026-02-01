<?php

namespace common\modules\payroll\models;

use Yii;

use common\modules\master\models\Employee;

/**
 * This is the model class for table "payroll_detail_l3".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $period_code
 * @property string|null $payroll_mode
 * @property string|null $generate_mode
 * @property float $basic
 * @property float $position_allow
 * @property float $ops_allow
 * @property float $fixed_income
 * @property float $overtime_allow
 * @property float $accodtn_allow
 * @property float $so_allow
 * @property float $ig_allow
 * @property float $doublepos_allow
 * @property float $misc_allow
 * @property float $var_income
 * @property float $actual_salary
 * @property float $jht_perusahaan
 * @property float $jp_perusahaan
 * @property float $jkm
 * @property float $jkk
 * @property float $bpjs_kes_perusahaan
 * @property float $employer_bpjs
 * @property float $thr
 * @property float $bonus
 * @property float $tunj_keseh
 * @property float $lembur
 * @property float $rev_absensi
 * @property float $tunj_pph21
 * @property float $cut_unpaid
 * @property float $cut_absensi
 * @property float $cut_alpha
 * @property float $other_income
 * @property float $bruto
 * @property float $employer_cost
 * @property float $bruto_tax
 * @property string|null $ter
 * @property float $ter_rate
 * @property float $pph21_dec_net
 * @property float $bruto_tax_year
 * @property float $biaya_jabatan_year
 * @property float $jp_jht_kary_year
 * @property float $ptkp
 * @property float $pkp
 * @property float $neto_year
 * @property float $pph21_year
 * @property float $pph21_jan_nov
 * @property float $pph21_net_employer
 * @property float $pph21
 * @property float $jht_kary
 * @property float $jp_kary
 * @property float $bpjs_kes_kary
 * @property float $ded_misc
 * @property float $total_potongan
 * @property float $thp
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property Employee $employee
 */
class PayrollDetailL3 extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PAYROLL_MODE_GROSS = 'GROSS';
    const PAYROLL_MODE_NET = 'NET';
    const PAYROLL_MODE_GROSS_UP = 'GROSS_UP';
    const GENERATE_MODE_BATCH = 'Batch';
    const GENERATE_MODE_SINGLE = 'Single';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_detail_l3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['generate_mode', 'ter', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['payroll_mode'], 'default', 'value' => 'GROSS_UP'],
            [['thp'], 'default', 'value' => 0.00],
            [['status_id'], 'default', 'value' => 1],
            [['employee_id', 'period_code'], 'required'],
            [['employee_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['payroll_mode', 'generate_mode'], 'string'],
            [['basic', 'position_allow', 'ops_allow', 'fixed_income', 'overtime_allow', 'accodtn_allow', 'so_allow', 'ig_allow', 'doublepos_allow', 'misc_allow', 'var_income', 'actual_salary', 'jht_perusahaan', 'jp_perusahaan', 'jkm', 'jkk', 'bpjs_kes_perusahaan', 'employer_bpjs', 'thr', 'bonus', 'tunj_keseh', 'lembur', 'rev_absensi', 'tunj_pph21', 'cut_unpaid', 'cut_absensi', 'cut_alpha', 'other_income', 'bruto', 'employer_cost', 'bruto_tax', 'ter_rate', 'pph21_dec_net', 'bruto_tax_year', 'biaya_jabatan_year', 'jp_jht_kary_year', 'ptkp', 'pkp', 'neto_year', 'pph21_year', 'pph21_jan_nov', 'pph21_net_employer', 'pph21', 'jht_kary', 'jp_kary', 'bpjs_kes_kary', 'ded_misc', 'total_potongan', 'thp'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['period_code', 'ter'], 'string', 'max' => 10],
            ['payroll_mode', 'in', 'range' => array_keys(self::optsPayrollMode())],
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
            'employee_id' => 'Employee',
            'period_code' => 'Period Code',
            'payroll_mode' => 'Payroll Mode',
            'generate_mode' => 'Generate Mode',
            'basic' => 'Basic Salary',
            'position_allow' => 'Position Allowance',
            'ops_allow' => 'Operational Allowance',
            'fixed_income' => 'Fixed Income',
            'overtime_allow' => 'Overtime Allowance',
            'accodtn_allow' => 'Accomodation Allowance',
            'so_allow' => 'So Allowance',
            'ig_allow' => 'Ig Allowance',
            'doublepos_allow' => 'Double Position Allowance',
            'misc_allow' => 'Misc Allowance',
            'var_income' => 'Var Income',
            'actual_salary' => 'Actual Salary',
            'jht_perusahaan' => 'JHT Perusahaan',
            'jp_perusahaan' => 'JP Perusahaan',
            'jkm' => 'JKM',
            'jkk' => 'JKK',
            'bpjs_kes_perusahaan' => 'BPJS Kes Perusahaan',
            'employer_bpjs' => 'BPJS Perusahaan',
            'thr' => 'THR',
            'bonus' => 'Bonus',
            'tunj_keseh' => 'Tunjangan Kesehatan',
            'lembur' => 'Lembur',
            'rev_absensi' => 'Revisi Absensi',
            'tunj_pph21' => 'Tunjangan PPh21',
            'cut_unpaid' => 'Unpaid Leave',
            'cut_absensi' => 'Potongan Absensi',
            'cut_alpha' => 'Potongan Alpha',
            'other_income' => 'Other Income',
            'bruto' => 'Bruto',
            'employer_cost' => 'Beban Perusahaan',
            'bruto_tax' => 'DPP',
            'ter' => 'TER',
            'ter_rate' => 'TER Rate',
            'pph21_dec_net' => 'PPh21 Net',
            'bruto_tax_year' => 'Bruto Tax Setahun',
            'biaya_jabatan_year' => 'Biaya Jabatan Setahun',
            'jp_jht_kary_year' => 'JP - JHT Karyawan Setahun',
            'ptkp' => 'PTKP',
            'pkp' => 'PKP',
            'neto_year' => 'Neto Setahun',
            'pph21_year' => 'PPh21 Setahun',
            'pph21_jan_nov' => 'PPh21 Jan - Nov',
            'pph21_net_employer' => 'PPh21 Net Karyawan',
            'pph21' => 'PPh21',
            'jht_kary' => 'JHT Karyawan',
            'jp_kary' => 'JP Karyawan',
            'bpjs_kes_kary' => 'BPJS Kesehatan Karyawan',
            'ded_misc' => 'Ded Misc',
            'total_potongan' => 'Total Potongan',
            'thp' => 'THP',
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


    /**
     * column payroll_mode ENUM value labels
     * @return string[]
     */
    public static function optsPayrollMode()
    {
        return [
            self::PAYROLL_MODE_GROSS => 'GROSS',
            self::PAYROLL_MODE_NET => 'NET',
            self::PAYROLL_MODE_GROSS_UP => 'GROSS_UP',
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
    public function displayPayrollMode()
    {
        return self::optsPayrollMode()[$this->payroll_mode];
    }

    /**
     * @return bool
     */
    public function isPayrollModeGross()
    {
        return $this->payroll_mode === self::PAYROLL_MODE_GROSS;
    }

    public function setPayrollModeToGross()
    {
        $this->payroll_mode = self::PAYROLL_MODE_GROSS;
    }

    /**
     * @return bool
     */
    public function isPayrollModeNet()
    {
        return $this->payroll_mode === self::PAYROLL_MODE_NET;
    }

    public function setPayrollModeToNet()
    {
        $this->payroll_mode = self::PAYROLL_MODE_NET;
    }

    /**
     * @return bool
     */
    public function isPayrollModeGrossup()
    {
        return $this->payroll_mode === self::PAYROLL_MODE_GROSS_UP;
    }

    public function setPayrollModeToGrossup()
    {
        $this->payroll_mode = self::PAYROLL_MODE_GROSS_UP;
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
