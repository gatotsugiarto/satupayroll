<?php

namespace common\modules\payroll\models;

use Yii;


use common\modules\master\models\Employee;
use common\modules\auth\models\User;

/**
 * This is the model class for table "formulir_1721_a1".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $tahun_pajak Tahun pajak
 * @property string $npwp_perusahaan
 * @property string $nama_perusahaan
 * @property string $alamat_perusahaan
 * @property string $nama_pegawai
 * @property string $npwp_nik_pegawai
 * @property string $status_ptkp TK/0, K/1, dst
 * @property string $alamat_pegawai
 * @property float $penghasilan_bruto
 * @property float $biaya_jabatan
 * @property float $iuran_pensiun_jht
 * @property float $penghasilan_neto
 * @property float $pkp
 * @property float $pph21_terutang
 * @property float $pph21_dipotong_perusahaan
 * @property string $nama_pejabat
 * @property string $sign_name
 * @property string $sign_image
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property Employee $employee
 */
class Formulir1721A1 extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formulir_1721_a1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['pph21_dipotong_perusahaan'], 'default', 'value' => 0.00],
            [['status_id'], 'default', 'value' => 1],
            [['employee_id', 'tahun_pajak', 'npwp_perusahaan', 'nama_perusahaan', 'alamat_perusahaan', 'nama_pegawai', 'npwp_nik_pegawai', 'status_ptkp', 'alamat_pegawai', 'nama_pejabat', 'sign_name', 'sign_image'], 'required'],
            [['employee_id', 'tahun_pajak', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['penghasilan_bruto', 'biaya_jabatan', 'iuran_pensiun_jht', 'penghasilan_neto', 'pkp', 'pph21_terutang', 'pph21_dipotong_perusahaan'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['npwp_perusahaan'], 'string', 'max' => 20],
            [['nama_perusahaan', 'nama_pegawai', 'sign_name'], 'string', 'max' => 150],
            [['alamat_perusahaan', 'alamat_pegawai', 'sign_image'], 'string', 'max' => 255],
            [['npwp_nik_pegawai'], 'string', 'max' => 25],
            [['status_ptkp'], 'string', 'max' => 10],
            [['nama_pejabat'], 'string', 'max' => 50],
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
            'tahun_pajak' => 'Tahun Pajak',
            'npwp_perusahaan' => 'Npwp Perusahaan',
            'nama_perusahaan' => 'Nama Perusahaan',
            'alamat_perusahaan' => 'Alamat Perusahaan',
            'nama_pegawai' => 'Nama Pegawai',
            'npwp_nik_pegawai' => 'Npwp Nik Pegawai',
            'status_ptkp' => 'Status Ptkp',
            'alamat_pegawai' => 'Alamat Pegawai',
            'penghasilan_bruto' => 'Penghasilan Bruto',
            'biaya_jabatan' => 'Biaya Jabatan',
            'iuran_pensiun_jht' => 'Iuran Pensiun Jht',
            'penghasilan_neto' => 'Penghasilan Neto',
            'pkp' => 'Pkp',
            'pph21_terutang' => 'Pph21 Terutang',
            'pph21_dipotong_perusahaan' => 'Pph21 Dipotong Perusahaan',
            'nama_pejabat' => 'Nama Pejabat',
            'sign_name' => 'Sign Name',
            'sign_image' => 'Sign Image',
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
