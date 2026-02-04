<?php

namespace common\modules\payroll\models;

use Yii;

use common\modules\master\models\Employee;
use common\modules\auth\models\User;

/**
 * This is the model class for table "bpjs_filing".
 *
 * @property int $id
 * @property int $employee_id
 * @property int|null $month
 * @property int|null $year
 * @property string $period_code
 * @property float|null $basic
 * @property float|null $kes_perush
 * @property float|null $kes_kary
 * @property float|null $total_kes
 * @property float|null $jht_perush
 * @property float|null $jht_kary
 * @property float|null $total_jht
 * @property float|null $jp_perush
 * @property float|null $jp_kary
 * @property float|null $total_jp
 * @property float|null $jkk
 * @property float|null $jkm
 * @property float|null $total
 * @property string|null $tanggal_bayar
 * @property string|null $va
 * @property string|null $bpi
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property Employee $employee
 */
class BpjsFiling extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpjs_filing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_bayar', 'va', 'bpi', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status_id'], 'default', 'value' => 1],
            [['total'], 'default', 'value' => 0.00],
            [['employee_id', 'period_code'], 'required'],
            [['employee_id', 'month', 'year', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['basic', 'kes_perush', 'kes_kary', 'total_kes', 'jht_perush', 'jht_kary', 'total_jht', 'jp_perush', 'jp_kary', 'total_jp', 'jkk', 'jkm', 'total'], 'number'],
            [['tanggal_bayar', 'created_at', 'updated_at'], 'safe'],
            [['period_code'], 'string', 'max' => 10],
            [['va', 'bpi'], 'string', 'max' => 50],
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
            'month' => 'Month',
            'year' => 'Year',
            'period_code' => 'Period Code',
            'basic' => 'Basic Salary',
            'kes_perush' => 'BPJS Kesehatan (Karyawan)',
            'kes_kary' => 'BPJS Kesehatan (Karyawan)',
            'total_kes' => 'BPJS Kesehatan',
            'jht_perush' => 'JHT (Perusahaan)',
            'jht_kary' => 'JHT (Karyawan)',
            'total_jht' => 'JHT',
            'jp_perush' => 'JP (Perusahaan)',
            'jp_kary' => 'JP (Karyawan)',
            'total_jp' => 'JP',
            'jkk' => 'JKK (Perusahaan)',
            'jkm' => 'JKM (Perusahaan)',
            'total' => 'Total Iuran Disetor',
            'tanggal_bayar' => 'Tanggal Bayar',
            'va' => 'VA',
            'bpi' => 'BPI',
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

}
