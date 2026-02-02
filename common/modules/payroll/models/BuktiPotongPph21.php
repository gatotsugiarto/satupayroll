<?php

namespace common\modules\payroll\models;

use Yii;

use common\modules\auth\models\User;

class BuktiPotongPph21 extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PEGAWAI_TETAP = 'TETAP';
    const STATUS_PEGAWAI_TIDAK_TETAP = 'TIDAK_TETAP';
    const STATUS_PEGAWAI_BUKAN_PEGAWAI = 'BUKAN_PEGAWAI';
    const SKEMA_PAJAK_NET = 'NET';
    const SKEMA_PAJAK_GROSS = 'GROSS';
    const SKEMA_PAJAK_GROSS_UP = 'GROSS-UP';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bukti_potong_pph21';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['pph21_ditanggung_perusahaan'], 'default', 'value' => 0.00],
            [['status_id'], 'default', 'value' => 1],
            [['masa_pajak', 'tahun_pajak', 'npwp_perusahaan', 'nama_perusahaan', 'npwp_nik_pegawai', 'nama_pegawai', 'status_pegawai', 'kode_objek_pajak', 'status_ptkp', 'skema_pajak'], 'required'],
            [['employee_id', 'masa_pajak', 'tahun_pajak', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['status_pegawai', 'skema_pajak'], 'string'],
            [['penghasilan_bruto', 'biaya_jabatan', 'iuran_pensiun_jht', 'penghasilan_neto', 'pph21_terutang', 'pph21_dipotong_karyawan', 'pph21_ditanggung_perusahaan'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['npwp_perusahaan'], 'string', 'max' => 20],
            [['nama_perusahaan', 'nama_pegawai'], 'string', 'max' => 150],
            [['npwp_nik_pegawai'], 'string', 'max' => 25],
            [['kode_objek_pajak'], 'string', 'max' => 15],
            [['status_ptkp'], 'string', 'max' => 10],
            ['status_pegawai', 'in', 'range' => array_keys(self::optsStatusPegawai())],
            ['skema_pajak', 'in', 'range' => array_keys(self::optsSkemaPajak())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Nomor Bukti Potong',
            'masa_pajak' => 'Masa Pajak',
            'tahun_pajak' => 'Tahun Pajak',
            'npwp_perusahaan' => 'Npwp Perusahaan',
            'nama_perusahaan' => 'Nama Perusahaan',
            'npwp_nik_pegawai' => 'Npwp Nik Pegawai',
            'nama_pegawai' => 'Nama Pegawai',
            'status_pegawai' => 'Status Pegawai',
            'kode_objek_pajak' => 'Kode Objek Pajak',
            'status_ptkp' => 'Status Ptkp',
            'penghasilan_bruto' => 'Penghasilan Bruto',
            'biaya_jabatan' => 'Biaya Jabatan',
            'iuran_pensiun_jht' => 'Iuran Pensiun Jht',
            'penghasilan_neto' => 'Penghasilan Neto',
            'pph21_terutang' => 'Pph21 Terutang',
            'pph21_dipotong_karyawan' => 'Pph21 Dipotong Karyawan',
            'pph21_ditanggung_perusahaan' => 'Pph21 Ditanggung Perusahaan',
            'skema_pajak' => 'Skema Pajak',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    /**
     * column status_pegawai ENUM value labels
     * @return string[]
     */
    public static function optsStatusPegawai()
    {
        return [
            self::STATUS_PEGAWAI_TETAP => 'TETAP',
            self::STATUS_PEGAWAI_TIDAK_TETAP => 'TIDAK_TETAP',
            self::STATUS_PEGAWAI_BUKAN_PEGAWAI => 'BUKAN_PEGAWAI',
        ];
    }

    /**
     * column skema_pajak ENUM value labels
     * @return string[]
     */
    public static function optsSkemaPajak()
    {
        return [
            self::SKEMA_PAJAK_NET => 'NET',
            self::SKEMA_PAJAK_GROSS => 'GROSS',
            self::SKEMA_PAJAK_GROSS_UP => 'GROSS-UP',
        ];
    }

    /**
     * @return string
     */
    public function displayStatusPegawai()
    {
        return self::optsStatusPegawai()[$this->status_pegawai];
    }

    /**
     * @return bool
     */
    public function isStatusPegawaiTetap()
    {
        return $this->status_pegawai === self::STATUS_PEGAWAI_TETAP;
    }

    public function setStatusPegawaiToTetap()
    {
        $this->status_pegawai = self::STATUS_PEGAWAI_TETAP;
    }

    /**
     * @return bool
     */
    public function isStatusPegawaiTidaktetap()
    {
        return $this->status_pegawai === self::STATUS_PEGAWAI_TIDAK_TETAP;
    }

    public function setStatusPegawaiToTidaktetap()
    {
        $this->status_pegawai = self::STATUS_PEGAWAI_TIDAK_TETAP;
    }

    /**
     * @return bool
     */
    public function isStatusPegawaiBukanpegawai()
    {
        return $this->status_pegawai === self::STATUS_PEGAWAI_BUKAN_PEGAWAI;
    }

    public function setStatusPegawaiToBukanpegawai()
    {
        $this->status_pegawai = self::STATUS_PEGAWAI_BUKAN_PEGAWAI;
    }

    /**
     * @return string
     */
    public function displaySkemaPajak()
    {
        return self::optsSkemaPajak()[$this->skema_pajak];
    }

    /**
     * @return bool
     */
    public function isSkemaPajakNet()
    {
        return $this->skema_pajak === self::SKEMA_PAJAK_NET;
    }

    public function setSkemaPajakToNet()
    {
        $this->skema_pajak = self::SKEMA_PAJAK_NET;
    }

    /**
     * @return bool
     */
    public function isSkemaPajakGross()
    {
        return $this->skema_pajak === self::SKEMA_PAJAK_GROSS;
    }

    public function setSkemaPajakToGross()
    {
        $this->skema_pajak = self::SKEMA_PAJAK_GROSS;
    }

    /**
     * @return bool
     */
    public function isSkemaPajakGrossUp()
    {
        return $this->skema_pajak === self::SKEMA_PAJAK_GROSS_UP;
    }

    public function setSkemaPajakToGrossUp()
    {
        $this->skema_pajak = self::SKEMA_PAJAK_GROSS_UP;
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
